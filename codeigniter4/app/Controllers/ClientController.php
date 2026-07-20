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

    private function calculerFrais($typeOperation, $montant)
    {
        $db = \Config\Database::connect();
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

        $fraisTransfert = $this->calculerFrais("transfert", $montant);
        $fraisRetrait = 0;
        if ($inclureFrais) {
            $fraisRetrait = $this->calculerFrais("retrait", $montant);
        }
        $totalFraisParEnvoi = $fraisTransfert + $fraisRetrait;
        $totalParEnvoi = $montant + $totalFraisParEnvoi;
        $totalGlobal = $totalParEnvoi * count($destinataires);

        $client = $this->clientModel->find($this->currentUser["id"]);
        if ($client["solde"] < $totalGlobal) return redirect()->back()->with("error", "Solde insuffisant. Besoin de " . number_format($totalGlobal, 0, ",", " ") . " Ar.");

        $db = \Config\Database::connect();
        $db->transStart();

        $envoyes = [];
        foreach ($destinataires as $dest) {
            if ($dest === $client["telephone"]) continue;
            $destClient = $this->clientModel->where("telephone", $dest)->first();
            if (!$destClient) continue;

            $this->transactionModel->insert(["id_client" => $client["id"], "type_operation" => "transfert", "montant" => $montant, "frais" => $totalFraisParEnvoi, "montant_total" => $totalParEnvoi, "destinataire" => $dest]);
            $this->clientModel->update($destClient["id"], ["solde" => $destClient["solde"] + $montant]);
            $envoyes[] = $dest;
        }

        $totalDebite = $totalParEnvoi * count($envoyes);
        $this->clientModel->update($client["id"], ["solde" => $client["solde"] - $totalDebite]);

        $db->transComplete();
        if ($db->transStatus() === false) return redirect()->back()->with("error", "Erreur lors des transferts.");

        $msg = count($envoyes) . " transfert(s) effectué(s)";
        if ($inclureFrais) $msg .= " (frais de retrait inclus)";
        return redirect()->to("/client/dashboard")->with("success", $msg . ".");
    }

    public function historique()
    {
        if (!$this->isLoggedIn()) return redirect()->to("/login");
        $transactions = $this->transactionModel->where("id_client", $this->currentUser["id"])->orderBy("date_creation", "DESC")->findAll();
        return $this->render("client/historique", ["transactions" => $transactions]);
    }
}
