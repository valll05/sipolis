<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    
    /**
     * Display profile page
     */
    public function index()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);
        
        $data = [
            'title' => 'Pengaturan Profil',
            'user' => $user,
        ];
        
        return view('profile/index', $data);
    }
    
    /**
     * Update profile data
     */
    public function update()
    {
        $userId = session()->get('user_id');
        
        $rules = [
            'nama' => 'required|min_length[3]|max_length[255]',
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'nama' => $this->request->getPost('nama'),
            'program_studi' => $this->request->getPost('program_studi'),
            'universitas' => $this->request->getPost('universitas'),
        ];
        
        // Skip validation in model since we're doing it here
        $this->userModel->skipValidation(true);
        
        if ($this->userModel->update($userId, $data)) {
            // Update session data
            session()->set('nama', $data['nama']);
            
            return redirect()->to('/profile')->with('success', 'Profil berhasil diperbarui!');
        }
        
        return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui profil.');
    }
    
    /**
     * Change password
     */
    public function changePassword()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);
        
        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]',
        ];
        
        $messages = [
            'confirm_password' => [
                'matches' => 'Konfirmasi password tidak cocok.',
            ],
        ];
        
        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Verify current password
        if (!password_verify($this->request->getPost('current_password'), $user['password'])) {
            return redirect()->back()->with('error', 'Password saat ini salah.');
        }
        
        // Update password
        $this->userModel->skipValidation(true);
        $this->userModel->update($userId, [
            'password' => password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT),
        ]);
        
        return redirect()->to('/profile')->with('success', 'Password berhasil diubah!');
    }
}
