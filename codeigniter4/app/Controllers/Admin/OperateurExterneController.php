<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class OperateurExterneController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $db->query("CREATE TABLE IF NOT EXISTS operateurs_externes (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nom TEXT NOT NULL,
            prefixe TEXT NOT NULL,
            commission_pct REAL DEFAULT 0,
            actif INTEGER DEFAULT 1,
            date_creation TEXT DEFAULT CURRENT_TIMESTAMP
        )");

        $operateurs = $db->query("SELECT * FROM operateurs_externes ORDER BY date_creation DESC")->getResultArray();
        return view("admin/operateurs", ["operateurs" => $operateurs]);
    }

    public function create()
    {
        $nom = trim($this->request->getPost("nom"));
        $prefixe = trim($this->request->getPost("prefixe"));
        $commissionPct = (float) $this->request->getPost("commission_pct");

        if (empty($nom) || empty($prefixe)) {
            return redirect()->back()->with("error", "Nom et préfixe obligatoires.");
        }

        $db = \Config\Database::connect();

        $exists = $db->query("SELECT id FROM operateurs_externes WHERE prefixe = ?", [$prefixe])->getRow();
        if ($exists) {
            return redirect()->back()->with("error", "Ce préfixe est déjà utilisé par un autre opérateur.");
        }

        $db->query("INSERT INTO operateurs_externes (nom, prefixe, commission_pct) VALUES (?, ?, ?)", [$nom, $prefixe, $commissionPct]);
        return redirect()->to("/admin/operateurs")->with("success", "Opérateur ajouté.");
    }

    public function toggle($id)
    {
        $db = \Config\Database::connect();
        $op = $db->query("SELECT id, actif FROM operateurs_externes WHERE id = ?", [$id])->getRow();
        if (!$op) return redirect()->back()->with("error", "Opérateur introuvable.");

        $nouveauStatut = $op->actif ? 0 : 1;
        $db->query("UPDATE operateurs_externes SET actif = ? WHERE id = ?", [$nouveauStatut, $id]);
        return redirect()->to("/admin/operateurs")->with("success", "Statut mis à jour.");
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->query("DELETE FROM operateurs_externes WHERE id = ?", [$id]);
        return redirect()->to("/admin/operateurs")->with("success", "Opérateur supprimé.");
    }
}
