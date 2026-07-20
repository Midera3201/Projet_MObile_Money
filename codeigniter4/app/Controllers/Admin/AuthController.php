<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class AuthController extends BaseController
{
    public function showLogin()
    {
        return view("admin/login");
    }

    public function login()
    {
        $username = $this->request->getPost("username");
        $password = $this->request->getPost("password");

        if ($username === "admin" && $password === "admin123") {
            $this->session->set("admin", ["username" => "admin"]);
            return redirect()->to("/admin");
        }

        return redirect()->back()->with("error", "Identifiants incorrects.");
    }

    public function logout()
    {
        $this->session->remove("admin");
        return redirect()->to("/admin/login");
    }
}
