<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class PrefixController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $prefixes = $db->query("SELECT * FROM prefices ORDER BY date_creation DESC")->getResultArray();
        return view("admin/prefixes", ["prefixes" => $prefixes]);
    }

    public function create()
    {
        $prefixe = trim($this->request->getPost("prefixe"));
        if (empty($prefixe)) return redirect()->back()->with("error", "Prefixe vide.");

        $db = \Config\Database::connect();
        $exists = $db->query("SELECT id FROM prefices WHERE prefixe = ?", [$prefixe])->getRow();
        if ($exists) return redirect()->back()->with("error", "Ce préfixe existe déjà.");

        $db->query("INSERT INTO prefices (prefixe) VALUES (?)", [$prefixe]);
        return redirect()->to("/admin/prefixes")->with("success", "Préfixe ajouté.");
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->query("DELETE FROM prefices WHERE id = ?", [$id]);
        return redirect()->to("/admin/prefixes")->with("success", "Préfixe supprimé.");
    }

    public function toggle($id)
    {
        $db = \Config\Database::connect();
        $prefixe = $db->query("SELECT id, statut FROM prefices WHERE id = ?", [$id])->getRow();
        if (!$prefixe) return redirect()->back()->with("error", "Préfixe introuvable.");

        $newStatut = $prefixe->statut ? 0 : 1;
        $db->query("UPDATE prefices SET statut = ? WHERE id = ?", [$newStatut, $id]);
        return redirect()->to("/admin/prefixes")->with("success", "Statut mis à jour.");
    }
}
