<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class BaseController extends Controller
{
    protected $helpers = ['url','form'];
    protected $session;
    protected $request;
    protected $currentUser;

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);
        $this->session = \Config\Services::session();
        $this->currentUser = $this->session->get('user');
        $this->initDatabase();
    }

    protected function initDatabase()
    {
        $db = \Config\Database::connect();
        $tables = $db->listTables();

        if (!in_array("prefices", $tables)) {
            $db->query("CREATE TABLE prefices (id INTEGER PRIMARY KEY AUTOINCREMENT, prefixe TEXT NOT NULL UNIQUE, statut INTEGER DEFAULT 1, date_creation DATETIME DEFAULT CURRENT_TIMESTAMP)");
            $db->query("INSERT INTO prefices (prefixe) VALUES ('033'), ('037')");
        }
        if (!in_array("types_operations", $tables)) {
            $db->query("CREATE TABLE types_operations (id INTEGER PRIMARY KEY AUTOINCREMENT, code TEXT NOT NULL UNIQUE, libelle TEXT NOT NULL)");
            $db->query("INSERT INTO types_operations (code, libelle) VALUES ('depot', 'Dépôt'), ('retrait', 'Retrait'), ('transfert', 'Transfert')");
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
            $db->query("CREATE TABLE transactions (id INTEGER PRIMARY KEY AUTOINCREMENT, id_client INTEGER NOT NULL, type_operation TEXT NOT NULL, montant REAL NOT NULL, frais REAL DEFAULT 0, montant_total REAL DEFAULT 0, destinataire TEXT DEFAULT NULL, batch_id TEXT DEFAULT NULL, date_creation DATETIME DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY (id_client) REFERENCES clients(id))");
        } else {
            $cols = $db->getFieldNames("transactions");
            if (!in_array("batch_id", $cols)) {
                $db->query("ALTER TABLE transactions ADD COLUMN batch_id TEXT DEFAULT NULL");
            }
        }
    }

    protected function isLoggedIn()
    {
        return $this->currentUser !== null;
    }

    protected function requireLogin()
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to('/login');
        }
    }

    protected function render($view, $data = [])
    {
        $data['currentUser'] = $this->currentUser;
        return view('templates/header', $data)
             . view($view, $data)
             . view('templates/footer', $data);
    }
}
