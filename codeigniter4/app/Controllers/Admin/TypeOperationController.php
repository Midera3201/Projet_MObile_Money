<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class TypeOperationController extends BaseController
{
    public function index()
    {
        $db    = \Config\Database::connect();
        $types = $db->table('types_operations')->get()->getResult();
        return view('admin/types/index', ['types' => $types]);
    }

    public function create()
    {
        $db = \Config\Database::connect();
        $db->table('types_operations')->insert([
            'nom'         => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
        ]);
        return redirect()->to('/admin/types')->with('success', 'Type ajoute');
    }

    public function update($id)
    {
        $db = \Config\Database::connect();
        $db->table('types_operations')->where('id', $id)->update([
            'nom'         => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
        ]);
        return redirect()->to('/admin/types')->with('success', 'Type modifie');
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->table('types_operations')->where('id', $id)->delete();
        return redirect()->to('/admin/types')->with('success', 'Type supprime');
    }
}