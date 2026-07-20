<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class ReportingController extends BaseController
{
    public function gains()
    {
        $db = \Config\Database::connect();

        $this->initTables($db);

        $gainsInternes = $this->calculerGainsInternes($db);
        $gainsExternes = $this->calculerGainsExternes($db);

        $totalGains = $gainsInternes + $gainsExternes;

        return view("admin/reporting_gains", [
            "gainsInternes" => $gainsInternes,
            "gainsExternes" => $gainsExternes,
            "totalGains" => $totalGains,
        ]);
    }

    public function montantsAEnvoyer()
    {
        $db = \Config\Database::connect();

        $this->initTables($db);

        $operateurs = $db->query("SELECT * FROM operateurs_externes WHERE actif = 1 ORDER BY nom")->getResultArray();

        $montants = [];
        foreach ($operateurs as $op) {
            $prefixe = $op["prefixe"];
            $result = $db->query(
                "SELECT COALESCE(SUM(t.montant * ? / 100), 0) as commission_totale, COUNT(*) as nb_transferts
                 FROM transactions t
                 WHERE t.type_operation = 'transfert'
                 AND t.destinataire IS NOT NULL
                 AND SUBSTR(t.destinataire, 1, 3) = ?",
                [$op["commission_pct"], $prefixe]
            )->getRow();

            $montants[] = [
                "nom" => $op["nom"],
                "prefixe" => $prefixe,
                "commission_pct" => $op["commission_pct"],
                "commission_totale" => $result->commission_totale,
                "nb_transferts" => $result->nb_transferts,
            ];
        }

        $totalAReverser = array_sum(array_column($montants, "commission_totale"));

        return view("admin/reporting_montants", [
            "montants" => $montants,
            "totalAReverser" => $totalAReverser,
        ]);
    }

    private function calculerGainsInternes($db)
    {
        $prefixesInternes = ["033", "037"];
        $placeholders = implode(",", array_fill(0, count($prefixesInternes), "?"));

        $result = $db->query(
            "SELECT COALESCE(SUM(t.frais), 0) as total_frais
             FROM transactions t
             WHERE t.type_operation IN ('retrait', 'transfert')
             AND t.destinataire IS NOT NULL
             AND SUBSTR(t.destinataire, 1, 3) NOT IN (SELECT prefixe FROM operateurs_externes WHERE actif = 1)",
            []
        )->getRow();

        $resultDepots = $db->query("SELECT COALESCE(SUM(frais), 0) as total FROM transactions WHERE type_operation = 'depot'")->getRow();

        return $result->total_frais + $resultDepots->total;
    }

    private function calculerGainsExternes($db)
    {
        $result = $db->query(
            "SELECT COALESCE(SUM(t.frais), 0) as total_frais
             FROM transactions t
             WHERE t.type_operation = 'transfert'
             AND t.destinataire IS NOT NULL
             AND SUBSTR(t.destinataire, 1, 3) IN (SELECT prefixe FROM operateurs_externes WHERE actif = 1)"
        )->getRow();

        $commissionCalculee = $db->query(
            "SELECT COALESCE(SUM(t.montant * e.commission_pct / 100), 0) as total_commission
             FROM transactions t
             JOIN operateurs_externes e ON SUBSTR(t.destinataire, 1, 3) = e.prefixe
             WHERE t.type_operation = 'transfert'"
        )->getRow();

        return $result->total_frais + $commissionCalculee->total_commission;
    }

    private function initTables($db)
    {
        $db->query("CREATE TABLE IF NOT EXISTS operateurs_externes (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nom TEXT NOT NULL,
            prefixe TEXT NOT NULL,
            commission_pct REAL DEFAULT 0,
            actif INTEGER DEFAULT 1,
            date_creation TEXT DEFAULT CURRENT_TIMESTAMP
        )");

        $db->query("CREATE TABLE IF NOT EXISTS transactions (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            id_client INTEGER,
            type_operation TEXT,
            montant REAL,
            frais REAL DEFAULT 0,
            montant_total REAL DEFAULT 0,
            destinataire TEXT,
            batch_id TEXT,
            date_creation TEXT DEFAULT CURRENT_TIMESTAMP
        )");
    }
}
