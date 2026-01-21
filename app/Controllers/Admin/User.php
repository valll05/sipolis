<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class User extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Kelola User',
            'users' => $this->userModel->where('role', 'user')->findAll(),
        ];
        
        return view('admin/user/index', $data);
    }
    
    public function pengajar()
    {
        $data = [
            'title' => 'Kelola Pengajar',
            'pengajar' => $this->userModel->getPengajar(),
        ];
        
        return view('admin/user/pengajar', $data);
    }
    
    public function createPengajar()
    {
        $data = [
            'title' => 'Tambah Pengajar',
        ];
        
        return view('admin/user/create_pengajar', $data);
    }
    
    public function storePengajar()
    {
        $rules = [
            'nama'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'pengajar',
        ];
        
        if ($this->userModel->insert($data)) {
            return redirect()->to('/admin/user/pengajar')->with('success', 'Pengajar berhasil ditambahkan.');
        }
        
        return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan.');
    }
    
    public function delete($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user || $user['role'] === 'admin') {
            return redirect()->back()->with('error', 'User tidak dapat dihapus.');
        }
        
        if ($this->userModel->delete($id)) {
            return redirect()->back()->with('success', 'User berhasil dihapus.');
        }
        
        return redirect()->back()->with('error', 'Terjadi kesalahan.');
    }
}
