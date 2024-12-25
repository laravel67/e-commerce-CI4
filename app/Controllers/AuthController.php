<?php

namespace App\Controllers;

use App\Models\User;
use Config\Services;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    protected $user;
    protected $validation;

    public function __construct()
    {
        // Inisialisasi use$user
        $this->user = new User();
        $this->validation = Services::validation();
    }

    public function showFormRegister()
    {
        $data = [
            'title' => 'Daftar Akun',
            'action' => base_url('/register')
        ];
        return view('pages/auth/register', $data);
    }

    public function showFormLogin()
    {
        $data = [
            'title'     => 'Masuk',
            'action'    => base_url('/login')
        ];
        return view('pages/auth/login', $data);
    }
    public function register()
    {
        $this->validation->setRules([
            'name' => 'required|min_length[3]|max_length[255]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'password_confirmation' => 'matches[password]',
        ]);
        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }
        $userData = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ];
        if ($this->user->save($userData)) {
            $userId = $this->user->insertID();
            $user = $this->user->find($userId);
            session()->set([
                'user_id' => $user['id'],
                'user_name' => $user['name'],
                'user_email' => $user['email'],
                'logged_in' => true
            ]);
            session()->setFlashdata('success', 'Registrasi berhasil!');
            return redirect()->to('/');
        } else {
            session()->setFlashdata('error', 'Registrasi gagal. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }

    public function login()
    {
        $this->validation->setRules([
            'email'     => 'required',
            'password'  => 'required'
        ]);

        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        $session    = session();
        $email      = $this->request->getPost('email');
        $password   = $this->request->getPost('password');
        $user       = $this->user->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            $session->set([
                'user_id'   => $user['id'],
                'logged_in' => true
            ]);
            if ($user['role'] == 'admin') {
                return redirect()->to(route_to('admin_dashboard'))->with('success', 'Login berhasil');
            } else {
                return redirect()->to('/')->with('success', 'Login berhasil');
            }
        } else {
            return redirect()->back()->with('error', 'Email & Password tidak ditemuka !');
        }
    }

    public function logout()
    {
        $session = Services::session();
        $session->destroy();
        return redirect()->to(base_url('/login'))->with('success', 'Logout berhasil.');
    }
}
