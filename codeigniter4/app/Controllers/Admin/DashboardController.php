<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $totalClients   = 0;
        $totalGains     = 0;

        if (in_array('clients', $db->listTables())) {
            $totalClients = $db->table('clients')->countAllResults();
        }

        if (in_array('transactions', $db->listTables())) {
            $row = $db->query("SELECT COALESCE(SUM(frais), 0) AS total FROM transactions")->getRow();
            $totalGains = $row->total ?? 0;
        }

        return view('admin/dashboard', [
            'totalClients' => $totalClients,
            'totalGains'   => $totalGains,
        ]);
    }
}
