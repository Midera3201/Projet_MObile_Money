<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class PrefixController extends BaseController
{
    public function index()
    {
        $db       = \Config\Database::connect();
        $this->initTable($db);
        $prefixes = $db->table('prefices')->get()->getResult();
        return view('admin/prefixes/index', ['prefixes' => $prefixes]);
    }

    public function create()
    {
        $db = \Config\Database::connect();
        $db->table('prefices')->insert(['prefixe' => $this->request->getPost('prefixe')]);
        return redirect()->to('/admin/prefixes')->with('success', 'Prefixe ajoute');
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->table('prefices')->where('id', $id)->delete();
        return redirect()->to('/admin/prefixes')->with('success', 'Prefixe supprime');
    }

    public function toggle($id)
    {
        $db     = \Config\Database::connect();
        $prefix = $db->table('prefices')->where('id', $id)->get()->getRow();
        $db->table('prefices')->where('id', $id)->update(['statut' => $prefix->statut ? 0 : 1]);
        return redirect()->to('/admin/prefixes');
    }

    private function initTable($db)
    {
        $tables = $db->listTables();
        if (!in_array('prefices', $tables)) {
            $db->query("CREATE TABLE prefices (id INTEGER PRIMARY KEY AUTOINCREMENT, prefixe TEXT NOT NULL UNIQUE, statut INTEGER DEFAULT 1, date_creation DATETIME DEFAULT CURRENT_TIMESTAMP)");
        }
    }
}
