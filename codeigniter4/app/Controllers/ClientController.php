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
        $destinataire = trim($this->request->getPost("destinataire"));
        $montant = (float) $this->request->getPost("montant");
        if ($montant <= 0) return redirect()->back()->with("error", "Montant invalide.");
        if ($destinataire === $this->currentUser["telephone"]) return redirect()->back()->with("error", "Transfert à soi-même interdit.");
        $destClient = $this->clientModel->where("telephone", $destinataire)->first();
        if (!$destClient) return redirect()->back()->with("error", "Destinataire introuvable.");
        $frais = $this->calculerFrais("transfert", $montant);
        $total = $montant + $frais;
        $client = $this->clientModel->find($this->currentUser["id"]);
        if ($client["solde"] < $total) return redirect()->back()->with("error", "Solde insuffisant.");
        $db = \Config\Database::connect();
        $db->transStart();
        $this->transactionModel->insert(["id_client" => $client["id"], "type_operation" => "transfert", "montant" => $montant, "frais" => $frais, "montant_total" => $total, "destinataire" => $destinataire]);
        $this->clientModel->update($client["id"], ["solde" => $client["solde"] - $total]);
        $this->clientModel->update($destClient["id"], ["solde" => $destClient["solde"] + $montant]);
        $db->transComplete();
        if ($db->transStatus() === false) return redirect()->back()->with("error", "Erreur lors du transfert.");
        return redirect()->to("/client/dashboard")->with("success", "Transfert de " . number_format($montant, 0, ",", " ") . " Ar vers " . $destinataire . " effectué (frais: " . number_format($frais, 0, ",", " ") . " Ar).");
    }

    public function historique()
    {
        if (!$this->isLoggedIn()) return redirect()->to("/login");
        $transactions = $this->transactionModel->where("id_client", $this->currentUser["id"])->orderBy("date_creation", "DESC")->findAll();
        return $this->render("client/historique", ["transactions" => $transactions]);
    }
}
