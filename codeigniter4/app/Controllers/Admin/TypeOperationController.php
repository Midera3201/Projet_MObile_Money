<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class TypeOperationController extends BaseController
{
    public function index()
    {
        $db    = \Config\Database::connect();
        $this->initTable($db);
        $types = $db->table('types_operations')->get()->getResult();
        return view('admin/types/index', ['types' => $types]);
    }

    public function create()
    {
        $db = \Config\Database::connect();
        $db->table('types_operations')->insert([
            'code'    => $this->request->getPost('code'),
            'libelle' => $this->request->getPost('libelle'),
        ]);
        return redirect()->to('/admin/types')->with('success', 'Type ajoute');
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->table('types_operations')->where('id', $id)->delete();
        return redirect()->to('/admin/types')->with('success', 'Type supprime');
    }

    private function initTable($db)
    {
        $tables = $db->listTables();
        if (!in_array('types_operations', $tables)) {
            $db->query("CREATE TABLE types_operations (id INTEGER PRIMARY KEY AUTOINCREMENT, code TEXT NOT NULL UNIQUE, libelle TEXT NOT NULL)");
        }
    }
}
