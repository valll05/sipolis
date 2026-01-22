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
    
    /**
     * Update profile photo
     */
    public function updatePhoto()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);
        
        $rules = [
            'foto' => 'uploaded[foto]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/gif]|max_size[foto,2048]',
        ];
        
        $messages = [
            'foto' => [
                'uploaded'  => 'Pilih foto untuk diupload.',
                'is_image'  => 'File harus berupa gambar.',
                'mime_in'   => 'Format foto harus JPG, JPEG, PNG, atau GIF.',
                'max_size'  => 'Ukuran foto maksimal 2 MB.',
            ],
        ];
        
        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }
        
        $file = $this->request->getFile('foto');
        
        // Delete old photo if exists
        if ($user['foto']) {
            $oldFile = ROOTPATH . 'public/uploads/profile/' . $user['foto'];
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }
        
        // Create directory if not exists
        $uploadPath = ROOTPATH . 'public/uploads/profile';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        
        // Save new photo
        $fileName = $userId . '_' . $file->getRandomName();
        $file->move($uploadPath, $fileName);
        
        // Update database
        $this->userModel->skipValidation(true);
        $this->userModel->update($userId, ['foto' => $fileName]);
        
        // Update session
        session()->set('foto', $fileName);
        
        return redirect()->to('/profile')->with('success', 'Foto profil berhasil diperbarui!');
    }
    
    /**
     * Delete profile photo
     */
    public function deletePhoto()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);
        
        if ($user['foto']) {
            $filePath = ROOTPATH . 'public/uploads/profile/' . $user['foto'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            
            $this->userModel->skipValidation(true);
            $this->userModel->update($userId, ['foto' => null]);
            
            session()->remove('foto');
            
            return redirect()->to('/profile')->with('success', 'Foto profil berhasil dihapus!');
        }
        
        return redirect()->to('/profile')->with('error', 'Tidak ada foto untuk dihapus.');
    }
}
