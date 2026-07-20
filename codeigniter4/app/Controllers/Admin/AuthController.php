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

        $db    = \Config\Database::connect();
        $admin = $db->table('admins')->where('login', $login)->get()->getRow();

        if ($admin && password_verify($password, $admin->password)) {
            $this->session->set('admin', [
                'id'    => $admin->id,
                'login' => $admin->login,
            ]);
            return redirect()->to('/admin');
        }

        return redirect()->to('/admin/login')->with('error', 'Login ou mot de passe incorrect');
    }

    public function logout()
    {
        $this->session->remove('admin');
        return redirect()->to('/admin/login');
    }
}