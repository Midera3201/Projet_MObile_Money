<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $data = [
            "totalClients" => $db->query("SELECT COUNT(*) as c FROM clients")->getRow()->c,
            "totalTransactions" => $db->query("SELECT COUNT(*) as c FROM transactions")->getRow()->c,
            "totalDepots" => $db->query("SELECT COUNT(*) as c FROM transactions WHERE type_operation='depot'")->getRow()->c,
            "totalRetraits" => $db->query("SELECT COUNT(*) as c FROM transactions WHERE type_operation='retrait'")->getRow()->c,
            "totalTransferts" => $db->query("SELECT COUNT(*) as c FROM transactions WHERE type_operation='transfert'")->getRow()->c,
        ];
        return view("admin/dashboard", $data);
    }
}
