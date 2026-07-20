<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class AuthController extends BaseController
{
    public function showLogin()
    {
        return view('admin/login');
    }

    public function login()
    {
        $login    = $this->request->getPost('login');
        $password = $this->request->getPost('password');
        $db       = \Config\Database::connect();

        $this->initAdminTable($db);
        $admin = $db->table('admins')->where('login', $login)->get()->getRow();

        if ($admin && password_verify($password, $admin->password)) {
            $this->session->set('admin', ['id' => $admin->id, 'login' => $admin->login]);
            return redirect()->to('/admin');
        }

        return redirect()->to('/admin/login')->with('error', 'Login ou mot de passe incorrect');
    }

    public function logout()
    {
        $this->session->remove('admin');
        return redirect()->to('/admin/login');
    }

    private function initAdminTable($db)
    {
        $tables = $db->listTables();
        if (!in_array('admins', $tables)) {
            $db->query("CREATE TABLE admins (id INTEGER PRIMARY KEY AUTOINCREMENT, login TEXT NOT NULL UNIQUE, password TEXT NOT NULL)");
            $hash = password_hash('admin123', PASSWORD_DEFAULT);
            $db->table('admins')->insert(['login' => 'admin', 'password' => $hash]);
        }
    }
}
