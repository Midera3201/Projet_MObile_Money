<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class CommissionController extends BaseController
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

        $operateurs = $db->query("SELECT * FROM operateurs_externes ORDER BY nom")->getResultArray();
        return view("admin/commissions", ["operateurs" => $operateurs]);
    }

    public function update($id)
    {
        $commissionPct = (float) $this->request->getPost("commission_pct");

        if ($commissionPct < 0 || $commissionPct > 100) {
            return redirect()->back()->with("error", "Le pourcentage doit etre entre 0 et 100.");
        }

        $db = \Config\Database::connect();
        $op = $db->query("SELECT id FROM operateurs_externes WHERE id = ?", [$id])->getRow();
        if (!$op) return redirect()->back()->with("error", "Operateur introuvable.");

        $db->query("UPDATE operateurs_externes SET commission_pct = ? WHERE id = ?", [$commissionPct, $id]);
        return redirect()->to("/admin/commissions")->with("success", "Commission mise a jour.");
    }
}
