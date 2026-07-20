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
        $this->initDatabase();
    }

    private function initDatabase()
    {
        $db = \Config\Database::connect();
        $tables = $db->listTables();

        if (!in_array("prefices", $tables)) {
            $db->query("CREATE TABLE prefices (id INTEGER PRIMARY KEY AUTOINCREMENT, prefixe TEXT NOT NULL UNIQUE, statut INTEGER DEFAULT 1, date_creation DATETIME DEFAULT CURRENT_TIMESTAMP)");
            $db->query("INSERT INTO prefices (prefixe) VALUES ('033'), ('037')");
        }
        if (!in_array("types_operations", $tables)) {
            $db->query("CREATE TABLE types_operations (id INTEGER PRIMARY KEY AUTOINCREMENT, code TEXT NOT NULL UNIQUE, libelle TEXT NOT NULL)");
            $db->query("INSERT INTO types_operations (code, libelle) VALUES ('depot', 'D?p?t'), ('retrait', 'Retrait'), ('transfert', 'Transfert')");
        }
        if (!in_array("baremes", $tables)) {
            $db->query("CREATE TABLE baremes (id INTEGER PRIMARY KEY AUTOINCREMENT, id_type_operation INTEGER NOT NULL, montant_min REAL NOT NULL, montant_max REAL NOT NULL, frais_fixe REAL DEFAULT 0, frais_pourcentage REAL DEFAULT 0, FOREIGN KEY (id_type_operation) REFERENCES types_operations(id))");
            $db->query("INSERT INTO baremes (id_type_operation, montant_min, montant_max, frais_fixe, frais_pourcentage) VALUES (2, 0, 1000, 50, 0), (2, 1001, 5000, 100, 1), (2, 5001, 20000, 200, 2), (2, 20001, 100000, 500, 3)");
            $db->query("INSERT INTO baremes (id_type_operation, montant_min, montant_max, frais_fixe, frais_pourcentage) VALUES (3, 0, 1000, 25, 0), (3, 1001, 5000, 50, 0.5), (3, 5001, 20000, 100, 1), (3, 20001, 100000, 200, 1.5)");
        }
        if (!in_array("clients", $tables)) {
            $db->query("CREATE TABLE clients (id INTEGER PRIMARY KEY AUTOINCREMENT, telephone TEXT NOT NULL UNIQUE, nom TEXT DEFAULT '', solde REAL DEFAULT 0, date_creation DATETIME DEFAULT CURRENT_TIMESTAMP)");
        }
        if (!in_array("transactions", $tables)) {
            $db->query("CREATE TABLE transactions (id INTEGER PRIMARY KEY AUTOINCREMENT, id_client INTEGER NOT NULL, type_operation TEXT NOT NULL, montant REAL NOT NULL, frais REAL DEFAULT 0, montant_total REAL DEFAULT 0, destinataire TEXT DEFAULT NULL, date_creation DATETIME DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY (id_client) REFERENCES clients(id))");
        }
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
            if (empty($telephone)) return redirect()->back()->with("error", "Veuillez entrer votre num?ro.");
            $prefixe = substr($telephone, 0, 3);
            $db = \Config\Database::connect();
            $check = $db->query("SELECT id FROM prefices WHERE prefixe = ? AND statut = 1", [$prefixe])->getRow();
            if (!$check) return redirect()->back()->with("error", "Num?ro invalide. Pr?fixes: 033, 037.");
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
        return redirect()->to("/login")->with("success", "D?connect?.");
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
        if ($db->transStatus() === false) return redirect()->back()->with("error", "Erreur lors du d?p?t.");
        return redirect()->to("/client/dashboard")->with("success", "D?p?t de " . number_format($montant, 0, ",", " ") . " FCFA effectu?.");
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
        return redirect()->to("/client/dashboard")->with("success", "Retrait de " . number_format($montant, 0, ",", " ") . " FCFA (frais: " . number_format($frais, 0, ",", " ") . " FCFA) effectu?.");
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
        if ($destinataire === $this->currentUser["telephone"]) return redirect()->back()->with("error", "Transfert ? soi-m?me interdit.");
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
        return redirect()->to("/client/dashboard")->with("success", "Transfert de " . number_format($montant, 0, ",", " ") . " FCFA vers " . $destinataire . " effectu? (frais: " . number_format($frais, 0, ",", " ") . " FCFA).");
    }

    public function historique()
    {
        if (!$this->isLoggedIn()) return redirect()->to("/login");
        $transactions = $this->transactionModel->where("id_client", $this->currentUser["id"])->orderBy("date_creation", "DESC")->findAll();
        return $this->render("client/historique", ["transactions" => $transactions]);
    }
}
