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

        if (!in_array('prefices', $tables)) {
<
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                prefixe TEXT NOT NULL UNIQUE,
                statut INTEGER DEFAULT 1,
                date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
            )");
            $db->query("INSERT INTO prefices (prefixe) VALUES ('033'), ('037')");
        }

        if (!in_array('types_operations', $tables)) {

                id INTEGER PRIMARY KEY AUTOINCREMENT,
                code TEXT NOT NULL UNIQUE,
                libelle TEXT NOT NULL
            )");
            $db->query("INSERT INTO types_operations (code, libelle) VALUES ('depot', 'Dépôt'), ('retrait', 'Retrait'), ('transfert', 'Transfert')");
        }

        if (!in_array('baremes', $tables)) {

                id INTEGER PRIMARY KEY AUTOINCREMENT,
                id_type_operation INTEGER NOT NULL,
                montant_min REAL NOT NULL,
                montant_max REAL NOT NULL,
                frais_fixe REAL DEFAULT 0,
                frais_pourcentage REAL DEFAULT 0,
                FOREIGN KEY (id_type_operation) REFERENCES types_operations(id)
            )");
            $db->query("INSERT INTO baremes (id_type_operation, montant_min, montant_max, frais_fixe, frais_pourcentage) VALUES
                (2, 0, 1000, 50, 0),
                (2, 1001, 5000, 100, 1),
                (2, 5001, 20000, 200, 2),
                (2, 20001, 100000, 500, 3)");
            $db->query("INSERT INTO baremes (id_type_operation, montant_min, montant_max, frais_fixe, frais_pourcentage) VALUES
                (3, 0, 1000, 25, 0),
                (3, 1001, 5000, 50, 0.5),
                (3, 5001, 20000, 100, 1),
                (3, 20001, 100000, 200, 1.5)");
        }

        if (!in_array('clients', $tables)) {

                id INTEGER PRIMARY KEY AUTOINCREMENT,
                telephone TEXT NOT NULL UNIQUE,
                nom TEXT DEFAULT '',
                solde REAL DEFAULT 0,
                date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
            )");
        }

        if (!in_array('transactions', $tables)) {

                id INTEGER PRIMARY KEY AUTOINCREMENT,
                id_client INTEGER NOT NULL,
                type_operation TEXT NOT NULL,
                montant REAL NOT NULL,
                frais REAL DEFAULT 0,
                montant_total REAL DEFAULT 0,
                destinataire TEXT DEFAULT NULL,
                date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (id_client) REFERENCES clients(id)
            )");
        }
    }

    public function login()
    {
        if ($this->isLoggedIn()) {
            return redirect()->to('/client/dashboard');
        }

        if ($this->request->getMethod() === 'POST') {
            $telephone = trim($this->request->getPost('telephone'));

            if (empty($telephone)) {
                return redirect()->back()->with('error', 'Veuillez entrer votre numéro de téléphone.');
            }

            $prefixe = substr($telephone, 0, 3);
            $db = \Config\Database::connect();
            $checkPrefix = $db->query("SELECT id FROM prefices WHERE prefixe = ? AND statut = 1", [$prefixe])->getRow();

            if (!$checkPrefix) {
                return redirect()->back()->with('error', 'Numéro invalide. Les préfixes valides sont 033 et 037.');
            }

            $client = $this->clientModel->where('telephone', $telephone)->first();

            if (!$client) {
                $this->clientModel->insert([
                    'telephone' => $telephone,
                    'solde' => 0
                ]);
                $client = $this->clientModel->where('telephone', $telephone)->first();
            }

            $this->session->set('user', $client);
            return redirect()->to('/client/dashboard')->with('success', 'Bienvenue ' . $telephone);
        }

        return $this->render('client/login');
    }

    public function logout()
    {
        $this->session->remove('user');
        return redirect()->to('/login')->with('success', 'Vous êtes déconnecté.');
    }

    public function dashboard()
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to('/login');
        }

        $client = $this->clientModel->find($this->currentUser['id']);
        $this->session->set('user', $client);

        return $this->render('client/dashboard', [
            'client' => $client
        ]);
    }
<
}
