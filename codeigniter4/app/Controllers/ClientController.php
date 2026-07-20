<?php
namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\TransactionModel;

class ClientController extends BaseController
{
    protected $clientModel;
    protected $transactionModel;

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);
        $this->clientModel = new ClientModel();
        $this->transactionModel = new TransactionModel();
        $this->initDatabase();
    }

    private function initDatabase()
    {
        $db = \Config\Database::connect();
        $tables = $db->listTables();

        if (!in_array('prefices', $tables)) {

    }

    public function login()
    {

        return $this->render('client/login');
    }

    public function logout()
    {
        $this->session->remove('user');

    }

    public function dashboard()
    {

}
