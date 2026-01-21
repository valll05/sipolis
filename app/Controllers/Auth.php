<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    
    /**
     * Show login form
     */
    public function login()
    {
        // If already logged in, redirect to dashboard
        if (session()->get('logged_in')) {
            return $this->redirectByRole();
        }
        
        return view('auth/login');
    }
    
    /**
     * Process login
     */
    public function processLogin()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        
        $user = $this->userModel->verifyLogin($email, $password);
        
        if ($user) {
            // Set session
            session()->set([
                'user_id'    => $user['id'],
                'nama'       => $user['nama'],
                'email'      => $user['email'],
                'role'       => $user['role'],
                'logged_in'  => true,
            ]);
            
            return $this->redirectByRole();
        }
        
        return redirect()->back()->withInput()->with('error', 'Email atau password salah.');
    }
    
    /**
     * Show register form
     */
    public function register()
    {
        // If already logged in, redirect to dashboard
        if (session()->get('logged_in')) {
            return $this->redirectByRole();
        }
        
        return view('auth/register');
    }
    
    /**
     * Process registration
     */
    public function processRegister()
    {
        $rules = [
            'nama'          => 'required|min_length[3]|max_length[255]',
            'email'         => 'required|valid_email|is_unique[users.email]',
            'password'      => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
            'program_studi' => 'required',
            'universitas'   => 'required',
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'nama'          => $this->request->getPost('nama'),
            'email'         => $this->request->getPost('email'),
            'password'      => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'program_studi' => $this->request->getPost('program_studi'),
            'universitas'   => $this->request->getPost('universitas'),
            'role'          => 'user',
        ];
        
        if ($this->userModel->insert($data)) {
            return redirect()->to('/auth/login')->with('success', 'Registrasi berhasil! Silakan login.');
        }
        
        return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
    }
    
    /**
     * Logout
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login')->with('success', 'Anda telah logout.');
    }
    
    /**
     * Redirect based on role
     */
    private function redirectByRole()
    {
        $role = session()->get('role');
        
        switch ($role) {
            case 'admin':
                return redirect()->to('/admin/dashboard');
            case 'pengajar':
                return redirect()->to('/pengajar/dashboard');
            default:
                // User diarahkan ke home page, bukan dashboard
                return redirect()->to('/');
        }
    }
}
