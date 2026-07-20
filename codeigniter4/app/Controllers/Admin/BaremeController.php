<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class BaremeController extends BaseController
{
    public function index()
    {
        $db      = \Config\Database::connect();
        $baremes = $db->query("
            SELECT b.*, to2.nom AS type_nom
            FROM baremes_frais b
            JOIN types_operations to2 ON b.type_operation_id = to2.id
            ORDER BY b.type_operation_id, b.montant_min
        ")->getResult();
        $types = $db->table('types_operations')->where('actif', 1)->get()->getResult();
        return view('admin/baremes/index', ['baremes' => $baremes, 'types' => $types]);
    }

    public function create()
    {
        $db = \Config\Database::connect();
        $db->table('baremes_frais')->insert([
            'type_operation_id' => $this->request->getPost('type_operation_id'),
            'montant_min'       => $this->request->getPost('montant_min'),
            'montant_max'       => $this->request->getPost('montant_max'),
            'frais_fixe'        => $this->request->getPost('frais_fixe'),
        ]);
        return redirect()->to('/admin/baremes')->with('success', 'Bareme ajoute');
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->table('baremes_frais')->where('id', $id)->delete();
        return redirect()->to('/admin/baremes')->with('success', 'Bareme supprime');
    }
}