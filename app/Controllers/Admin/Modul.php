<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ModulModel;
use App\Models\UserModel;

class Modul extends BaseController
{
    protected $modulModel;
    protected $userModel;
    
    public function __construct()
    {
        $this->modulModel = new ModulModel();
        $this->userModel = new UserModel();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Kelola Modul',
            'moduls' => $this->modulModel->getModulWithPengajar(),
        ];
        
        return view('admin/modul/index', $data);
    }
    
    public function create()
    {
        $data = [
            'title' => 'Tambah Modul',
            'pengajar' => $this->userModel->getPengajar(),
        ];
        
        return view('admin/modul/create', $data);
    }
    
    public function store()
    {
        $rules = [
            'judul'    => 'required|min_length[3]',
            'kategori' => 'required|in_list[sosial,produksi,distribusi,neraca]',
            'file_pdf' => 'uploaded[file_pdf]|mime_in[file_pdf,application/pdf]|max_size[file_pdf,10240]',
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $file = $this->request->getFile('file_pdf');
        $fileName = $file->getRandomName();
        $file->move(ROOTPATH . 'public/uploads/modul', $fileName);
        
        $data = [
            'judul'       => $this->request->getPost('judul'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'kategori'    => $this->request->getPost('kategori'),
            'file_pdf'    => $fileName,
            'ukuran_file' => $this->formatFileSize($file->getSize()),
            'pengajar_id' => $this->request->getPost('pengajar_id') ?: null,
        ];
        
        if ($this->modulModel->insert($data)) {
            return redirect()->to('/admin/modul')->with('success', 'Modul berhasil ditambahkan.');
        }
        
        return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan.');
    }
    
    public function edit($id)
    {
        $modul = $this->modulModel->find($id);
        
        if (!$modul) {
            return redirect()->to('/admin/modul')->with('error', 'Modul tidak ditemukan.');
        }
        
        $data = [
            'title'    => 'Edit Modul',
            'modul'    => $modul,
            'pengajar' => $this->userModel->getPengajar(),
        ];
        
        return view('admin/modul/edit', $data);
    }
    
    public function update($id)
    {
        $modul = $this->modulModel->find($id);
        
        if (!$modul) {
            return redirect()->to('/admin/modul')->with('error', 'Modul tidak ditemukan.');
        }
        
        $rules = [
            'judul'    => 'required|min_length[3]',
            'kategori' => 'required|in_list[sosial,produksi,distribusi,neraca]',
        ];
        
        // Only validate file if uploaded
        $file = $this->request->getFile('file_pdf');
        if ($file && $file->isValid()) {
            $rules['file_pdf'] = 'mime_in[file_pdf,application/pdf]|max_size[file_pdf,10240]';
        }
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'judul'       => $this->request->getPost('judul'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'kategori'    => $this->request->getPost('kategori'),
            'pengajar_id' => $this->request->getPost('pengajar_id') ?: null,
        ];
        
        // Handle file upload if new file
        if ($file && $file->isValid()) {
            // Delete old file
            $oldFile = ROOTPATH . 'public/uploads/modul/' . $modul['file_pdf'];
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
            
            $fileName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/modul', $fileName);
            $data['file_pdf'] = $fileName;
            $data['ukuran_file'] = $this->formatFileSize($file->getSize());
        }
        
        if ($this->modulModel->update($id, $data)) {
            return redirect()->to('/admin/modul')->with('success', 'Modul berhasil diperbarui.');
        }
        
        return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan.');
    }
    
    public function delete($id)
    {
        $modul = $this->modulModel->find($id);
        
        if (!$modul) {
            return redirect()->to('/admin/modul')->with('error', 'Modul tidak ditemukan.');
        }
        
        // Delete file
        $filePath = ROOTPATH . 'public/uploads/modul/' . $modul['file_pdf'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        
        if ($this->modulModel->delete($id)) {
            return redirect()->to('/admin/modul')->with('success', 'Modul berhasil dihapus.');
        }
        
        return redirect()->back()->with('error', 'Terjadi kesalahan.');
    }
    
    private function formatFileSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}
