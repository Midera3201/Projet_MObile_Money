<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // Situation des gains (frais retrait + transfert)
        $gains = $db->query("
            SELECT
                to2.nom AS type_operation,
                COUNT(t.id) AS nombre_operations,
                COALESCE(SUM(t.montant), 0) AS total_montant,
                COALESCE(SUM(t.frais), 0) AS total_frais
            FROM transactions t
            JOIN types_operations to2 ON t.type_operation_id = to2.id
            WHERE to2.nom IN ('Retrait', 'Transfert')
            GROUP BY to2.nom
        ")->getResult();

        // Situation des comptes clients
        $comptes = $db->query("
            SELECT c.*, COUNT(t.id) AS nombre_transactions
            FROM comptes c
            LEFT JOIN transactions t ON c.id = t.compte_id
            GROUP BY c.id
            ORDER BY c.created_at DESC
        ")->getResult();

        $totalClients = $db->table('comptes')->countAllResults();
        $totalGains   = 0;
        foreach ($gains as $g) {
            $totalGains += $g->total_frais;
        }

        return view('admin/dashboard', [
            'gains'        => $gains,
            'comptes'      => $comptes,
            'totalClients' => $totalClients,
            'totalGains'   => $totalGains,
        ]);
    }
}