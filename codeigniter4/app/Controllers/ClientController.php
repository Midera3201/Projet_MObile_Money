<?php
namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\TransactionModel;

class ClientController extends BaseController
{
    protected $clientModel;
    protected $transactionModel;

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);
        $this->clientModel = new ClientModel();
        $this->transactionModel = new TransactionModel();
    }

    private function calculerFrais($typeOperation, $montant, $destinataire = null)
    {
        $db = \Config\Database::connect();

        if ($typeOperation === "transfert" && $destinataire && $this->currentUser) {
            $prefixeSource = substr($this->currentUser["telephone"], 0, 3);
            $prefixeDest = substr($destinataire, 0, 3);
            $promo = $db->query("SELECT frais_fixe_promo, frais_pourcentage_promo FROM promotions WHERE id_type_operation = (SELECT id FROM types_operations WHERE code = ?) AND prefixe_source = ? AND prefixe_dest = ? AND statut = 1 AND DATE('now') BETWEEN date_debut AND date_fin AND ? BETWEEN montant_min AND montant_max", [$typeOperation, $prefixeSource, $prefixeDest, $montant])->getRow();
            if ($promo) {
                return $promo->frais_fixe_promo + ($montant * $promo->frais_pourcentage_promo / 100);
            }
        }

        $bareme = $db->query("SELECT frais_fixe, frais_pourcentage FROM baremes b JOIN types_operations t ON b.id_type_operation = t.id WHERE t.code = ? AND ? BETWEEN b.montant_min AND b.montant_max", [$typeOperation, $montant])->getRow();
        if (!$bareme) return 0;
        return $bareme->frais_fixe + ($montant * $bareme->frais_pourcentage / 100);
    }

    public function login()
    {
        if ($this->isLoggedIn()) return redirect()->to("/client/dashboard");
        if ($this->request->getMethod() === "POST") {
            $telephone = trim($this->request->getPost("telephone"));
            if (empty($telephone)) return redirect()->back()->with("error", "Veuillez entrer votre numéro.");
            $prefixe = substr($telephone, 0, 3);
            $db = \Config\Database::connect();
            $check = $db->query("SELECT id FROM prefices WHERE prefixe = ? AND statut = 1", [$prefixe])->getRow();
            if (!$check) return redirect()->back()->with("error", "Numéro invalide. Préfixes: 033, 037.");
            $client = $this->clientModel->where("telephone", $telephone)->first();
            if (!$client) {
                $this->clientModel->insert(["telephone" => $telephone, "solde" => 0]);
                $client = $this->clientModel->where("telephone", $telephone)->first();
            }
            $this->session->set("user", $client);
            return redirect()->to("/client/dashboard")->with("success", "Bienvenue " . $telephone);
        }
        return $this->render("client/login");
    }

    public function logout()
    {
        $this->session->remove("user");
        return redirect()->to("/login")->with("success", "Déconnecté.");
    }

    public function dashboard()
    {
        if (!$this->isLoggedIn()) return redirect()->to("/login");
        $client = $this->clientModel->find($this->currentUser["id"]);
        $this->session->set("user", $client);
        return $this->render("client/dashboard", ["client" => $client]);
    }

    public function depot()
    {
        if (!$this->isLoggedIn()) return redirect()->to("/login");
        return $this->render("client/depot");
    }

    public function storeDepot()
    {
        if (!$this->isLoggedIn()) return redirect()->to("/login");
        $montant = (float) $this->request->getPost("montant");
        if ($montant <= 0) return redirect()->back()->with("error", "Montant invalide.");
        $db = \Config\Database::connect();
        $db->transStart();
        $this->transactionModel->insert(["id_client" => $this->currentUser["id"], "type_operation" => "depot", "montant" => $montant, "frais" => 0, "montant_total" => $montant]);
        $this->clientModel->update($this->currentUser["id"], ["solde" => $this->currentUser["solde"] + $montant]);
        $db->transComplete();
        if ($db->transStatus() === false) return redirect()->back()->with("error", "Erreur lors du dépôt.");
        return redirect()->to("/client/dashboard")->with("success", "Dépôt de " . number_format($montant, 0, ",", " ") . " Ar effectué.");
    }

    public function retrait()
    {
        if (!$this->isLoggedIn()) return redirect()->to("/login");
        return $this->render("client/retrait");
    }

    public function storeRetrait()
    {
        if (!$this->isLoggedIn()) return redirect()->to("/login");
        $montant = (float) $this->request->getPost("montant");
        if ($montant <= 0) return redirect()->back()->with("error", "Montant invalide.");
        $frais = $this->calculerFrais("retrait", $montant);
        $total = $montant + $frais;
        $client = $this->clientModel->find($this->currentUser["id"]);
        if ($client["solde"] < $total) return redirect()->back()->with("error", "Solde insuffisant.");
        $db = \Config\Database::connect();
        $db->transStart();
        $this->transactionModel->insert(["id_client" => $client["id"], "type_operation" => "retrait", "montant" => $montant, "frais" => $frais, "montant_total" => $total]);
        $this->clientModel->update($client["id"], ["solde" => $client["solde"] - $total]);
        $db->transComplete();
        if ($db->transStatus() === false) return redirect()->back()->with("error", "Erreur lors du retrait.");
        return redirect()->to("/client/dashboard")->with("success", "Retrait de " . number_format($montant, 0, ",", " ") . " Ar (frais: " . number_format($frais, 0, ",", " ") . " Ar) effectué.");
    }

    public function transfert()
    {
        if (!$this->isLoggedIn()) return redirect()->to("/login");
        return $this->render("client/transfert");
    }

    public function storeTransfert()
    {
        if (!$this->isLoggedIn()) return redirect()->to("/login");
        $destinatairesRaw = trim($this->request->getPost("destinataires"));
        $montant = (float) $this->request->getPost("montant");
        $inclureFrais = $this->request->getPost("inclure_frais") ? true : false;

        if ($montant <= 0) return redirect()->back()->with("error", "Montant invalide.");

        $destinataires = array_filter(array_map("trim", preg_split("/[\r\n,]+/", $destinatairesRaw)));
        if (empty($destinataires)) return redirect()->back()->with("error", "Aucun destinataire valide.");

        $nbDestinataires = count($destinataires);
        $montantPart = floor($montant / $nbDestinataires);
        $reste = $montant - ($montantPart * $nbDestinataires);

        $fraisTransfert = $this->calculerFrais("transfert", $montantPart);
        $fraisRetrait = 0;
        if ($inclureFrais) {
            $fraisRetrait = $this->calculerFrais("retrait", $montantPart);
        }
        $totalFraisParEnvoi = $fraisTransfert + $fraisRetrait;
        $totalGlobal = ($montantPart * $nbDestinataires) + ($totalFraisParEnvoi * $nbDestinataires) + $reste;

        $client = $this->clientModel->find($this->currentUser["id"]);
        if ($client["solde"] < $totalGlobal) return redirect()->back()->with("error", "Solde insuffisant. Besoin de " . number_format($totalGlobal, 0, ",", " ") . " Ar.");

        $db = \Config\Database::connect();
        $db->transStart();

        $batchId = uniqid("B", true);
        $envoyes = [];
        foreach ($destinataires as $i => $dest) {
            if ($dest === $client["telephone"]) continue;
            $destClient = $this->clientModel->where("telephone", $dest)->first();
            if (!$destClient) continue;

            $montantDest = $montantPart + ($i === $nbDestinataires - 1 ? $reste : 0);
            $fraisDest = $this->calculerFrais("transfert", $montantDest, $dest);
            $fraisRetraitDest = 0;
            if ($inclureFrais) $fraisRetraitDest = $this->calculerFrais("retrait", $montantDest, $dest);
            $totalFraisDest = $fraisDest + $fraisRetraitDest;
            $totalDest = $montantDest + $totalFraisDest;

            $this->transactionModel->insert(["id_client" => $client["id"], "type_operation" => "transfert", "montant" => $montantDest, "frais" => $totalFraisDest, "montant_total" => $totalDest, "destinataire" => $dest, "batch_id" => $batchId]);
            $this->clientModel->update($destClient["id"], ["solde" => $destClient["solde"] + $montantDest]);
            $envoyes[] = $dest;
        }

        $this->clientModel->update($client["id"], ["solde" => $client["solde"] - $totalGlobal]);

        $db->transComplete();
        if ($db->transStatus() === false) return redirect()->back()->with("error", "Erreur lors des transferts.");

        $msg = count($envoyes) . " transfert(s) effectué(s)";
        if ($inclureFrais) $msg .= " (frais de retrait inclus)";
        return redirect()->to("/client/dashboard")->with("success", $msg . ".");
    }

    public function epargne()
    {
        if (!$this->isLoggedIn()) return redirect()->to("/login");
        $db = \Config\Database::connect();
        $params = $db->query("SELECT * FROM parametres_epargne ORDER BY id DESC LIMIT 1")->getRow();
        return $this->render("client/epargne", ["params" => $params]);
    }

    public function storeEpargneDepot()
    {
        if (!$this->isLoggedIn()) return redirect()->to("/login");
        $montant = (float) $this->request->getPost("montant");
        if ($montant <= 0) return redirect()->back()->with("error", "Montant invalide.");
        $client = $this->clientModel->find($this->currentUser["id"]);
        if ($client["solde"] < $montant) return redirect()->back()->with("error", "Solde insuffisant.");
        $db = \Config\Database::connect();
        $db->transStart();
        $this->clientModel->update($client["id"], ["solde" => $client["solde"] - $montant, "solde_epargne" => $client["solde_epargne"] + $montant]);
        $this->transactionModel->insert(["id_client" => $client["id"], "type_operation" => "epargne_depot", "montant" => $montant, "frais" => 0, "montant_total" => $montant, "destinataire" => "Épargne"]);
        $db->transComplete();
        if ($db->transStatus() === false) return redirect()->back()->with("error", "Erreur lors du dépôt épargne.");
        return redirect()->to("/client/epargne")->with("success", number_format($montant, 0, ",", " ") . " Ar versé sur votre épargne.");
    }

    public function storeEpargneRetrait()
    {
        if (!$this->isLoggedIn()) return redirect()->to("/login");
        $montant = (float) $this->request->getPost("montant");
        if ($montant <= 0) return redirect()->back()->with("error", "Montant invalide.");
        $client = $this->clientModel->find($this->currentUser["id"]);
        if ($client["solde_epargne"] < $montant) return redirect()->back()->with("error", "Solde épargne insuffisant.");
        $db = \Config\Database::connect();
        $db->transStart();
        $this->clientModel->update($client["id"], ["solde" => $client["solde"] + $montant, "solde_epargne" => $client["solde_epargne"] - $montant]);
        $this->transactionModel->insert(["id_client" => $client["id"], "type_operation" => "epargne_retrait", "montant" => $montant, "frais" => 0, "montant_total" => $montant, "destinataire" => "Épargne"]);
        $db->transComplete();
        if ($db->transStatus() === false) return redirect()->back()->with("error", "Erreur lors du retrait épargne.");
        return redirect()->to("/client/epargne")->with("success", number_format($montant, 0, ",", " ") . " Ar retiré de votre épargne.");
    }

    public function historique()
    {
        if (!$this->isLoggedIn()) return redirect()->to("/login");
        $transactions = $this->transactionModel->where("id_client", $this->currentUser["id"])->orderBy("date_creation", "DESC")->findAll();
        $batchIds = array_unique(array_filter(array_column($transactions, "batch_id")));
        return $this->render("client/historique", ["transactions" => $transactions, "batchIds" => $batchIds]);
    }
}
