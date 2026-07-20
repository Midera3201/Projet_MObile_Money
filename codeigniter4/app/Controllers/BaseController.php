<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class BaseController extends Controller
{
    protected $helpers = ['url','form'];
    protected $session;
    protected $request;
    protected $currentUser;

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);
        $this->session = \Config\Services::session();
        $this->currentUser = $this->session->get('user');
    }

    protected function isLoggedIn()
    {
        return $this->currentUser !== null;
    }

    protected function requireLogin()
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to('/login');
        }
    }

    protected function render($view, $data = [])
    {
        $data['currentUser'] = $this->currentUser;
        return view('templates/header', $data)
             . view($view, $data)
             . view('templates/footer', $data);
    }
}
