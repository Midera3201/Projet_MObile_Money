<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class PrefixController extends BaseController
{
    public function index()
    {
        $db       = \Config\Database::connect();
        $prefixes = $db->table('prefixes')->get()->getResult();
        return view('admin/prefixes/index', ['prefixes' => $prefixes]);
    }

    public function create()
    {
        $prefixe = $this->request->getPost('prefixe');
        $db      = \Config\Database::connect();
        $db->table('prefixes')->insert(['prefixe' => $prefixe]);
        return redirect()->to('/admin/prefixes')->with('success', 'Prefixe ajoute');
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->table('prefixes')->where('id', $id)->delete();
        return redirect()->to('/admin/prefixes')->with('success', 'Prefixe supprime');
    }

    public function toggle($id)
    {
        $db     = \Config\Database::connect();
        $prefix = $db->table('prefixes')->where('id', $id)->get()->getRow();
        $nouveau = $prefix->actif ? 0 : 1;
        $db->table('prefixes')->where('id', $id)->update(['actif' => $nouveau]);
        return redirect()->to('/admin/prefixes');
    }
}