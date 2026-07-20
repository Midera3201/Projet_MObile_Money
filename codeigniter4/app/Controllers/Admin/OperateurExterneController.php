<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class OperateurExterneController extends BaseController
{
    public function index()
    {
        $db         = \Config\Database::connect();
        $this->initTable($db);
        $operateurs = $db->table('operateurs_externes')->get()->getResult();
        return view('admin/operateurs/index', ['operateurs' => $operateurs]);
    }

    public function create()
    {
        $db = \Config\Database::connect();
        $db->table('operateurs_externes')->insert([
            'nom'            => $this->request->getPost('nom'),
            'prefixe'        => $this->request->getPost('prefixe'),
            'commission_pct' => $this->request->getPost('commission_pct') ?: 0,
        ]);
        return redirect()->to('/admin/operateurs')->with('success', 'Operateur ajoute');
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->table('operateurs_externes')->where('id', $id)->delete();
        return redirect()->to('/admin/operateurs')->with('success', 'Operateur supprime');
    }

    public function toggle($id)
    {
        $db        = \Config\Database::connect();
        $op        = $db->table('operateurs_externes')->where('id', $id)->get()->getRow();
        $nouveau   = $op->actif ? 0 : 1;
        $db->table('operateurs_externes')->where('id', $id)->update(['actif' => $nouveau]);
        return redirect()->to('/admin/operateurs')->with('success', 'Statut mis a jour');
    }

    private function initTable($db)
    {
        $tables = $db->listTables();
        if (!in_array('operateurs_externes', $tables)) {
            $db->query("CREATE TABLE operateurs_externes (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nom TEXT NOT NULL,
                prefixe TEXT NOT NULL,
                commission_pct REAL DEFAULT 0,
                actif INTEGER DEFAULT 1
            )");
            $db->table('operateurs_externes')->insert(['nom' => 'Orange', 'prefixe' => '032', 'commission_pct' => 1.5]);
            $db->table('operateurs_externes')->insert(['nom' => 'Yas', 'prefixe' => '034', 'commission_pct' => 2.0]);
            $db->table('operateurs_externes')->insert(['nom' => 'MVola', 'prefixe' => '038', 'commission_pct' => 1.0]);
        }
    }
}
