<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class TypeOperationController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $types = $db->query("SELECT * FROM types_operations ORDER BY code")->getResultArray();
        return view("admin/types", ["types" => $types]);
    }

    public function create()
    {
        $code = trim($this->request->getPost("code"));
        $libelle = trim($this->request->getPost("libelle"));
        if (empty($code) || empty($libelle)) return redirect()->back()->with("error", "Champs obligatoires.");

        $db = \Config\Database::connect();
        $exists = $db->query("SELECT id FROM types_operations WHERE code = ?", [$code])->getRow();
        if ($exists) return redirect()->back()->with("error", "Ce code existe déjà.");

        $db->query("INSERT INTO types_operations (code, libelle) VALUES (?, ?)", [$code, $libelle]);
        return redirect()->to("/admin/types")->with("success", "Type d'opération ajouté.");
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->query("DELETE FROM baremes WHERE id_type_operation = ?", [$id]);
        $db->query("DELETE FROM types_operations WHERE id = ?", [$id]);
        return redirect()->to("/admin/types")->with("success", "Type supprimé.");
    }
}
