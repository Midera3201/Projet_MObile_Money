<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class BaremeController extends BaseController
{
    public function index()
    {
        $db      = \Config\Database::connect();
        $this->initTable($db);
        $baremes = $db->query("
            SELECT b.*, t.libelle AS type_libelle
            FROM baremes b
            JOIN types_operations t ON b.id_type_operation = t.id
            ORDER BY b.id_type_operation, b.montant_min
        ")->getResult();
        $types = $db->table('types_operations')->get()->getResult();
        return view('admin/baremes/index', ['baremes' => $baremes, 'types' => $types]);
    }

    public function create()
    {
        $db = \Config\Database::connect();
        $db->table('baremes')->insert([
            'id_type_operation'   => $this->request->getPost('id_type_operation'),
            'montant_min'         => $this->request->getPost('montant_min'),
            'montant_max'         => $this->request->getPost('montant_max'),
            'frais_fixe'          => $this->request->getPost('frais_fixe') ?: 0,
            'frais_pourcentage'   => $this->request->getPost('frais_pourcentage') ?: 0,
        ]);
        return redirect()->to('/admin/baremes')->with('success', 'Bareme ajoute');
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->table('baremes')->where('id', $id)->delete();
        return redirect()->to('/admin/baremes')->with('success', 'Bareme supprime');
    }

    private function initTable($db)
    {
        $tables = $db->listTables();
        if (!in_array('baremes', $tables)) {
            $db->query("CREATE TABLE baremes (id INTEGER PRIMARY KEY AUTOINCREMENT, id_type_operation INTEGER NOT NULL, montant_min REAL NOT NULL, montant_max REAL NOT NULL, frais_fixe REAL DEFAULT 0, frais_pourcentage REAL DEFAULT 0, FOREIGN KEY (id_type_operation) REFERENCES types_operations(id))");
        }
    }
}
