<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JadwalModel;
use App\Models\UserModel;

class Jadwal extends BaseController
{
    protected $jadwalModel;
    protected $userModel;
    
    public function __construct()
    {
        $this->jadwalModel = new JadwalModel();
        $this->userModel = new UserModel();
    }
    
    public function index()
    {
        $data = [
            'title'    => 'Kelola Jadwal',
            'jadwals'  => $this->jadwalModel->getJadwalWithPengajar(),
            'pengajar' => $this->userModel->getPengajar(),
        ];
        
        return view('admin/jadwal/index', $data);
    }
    
    public function getEvents()
    {
        $events = $this->jadwalModel->getForCalendar();
        return $this->response->setJSON($events);
    }
    
    public function create()
    {
        $data = [
            'title'    => 'Tambah Jadwal',
            'pengajar' => $this->userModel->getPengajar(),
        ];
        
        return view('admin/jadwal/create', $data);
    }
    
    public function store()
    {
        $rules = [
            'pengajar_id' => 'required|integer',
            'tanggal'     => 'required|valid_date',
            'waktu'       => 'required',
            'topik'       => 'required|min_length[3]',
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'pengajar_id' => $this->request->getPost('pengajar_id'),
            'tanggal'     => $this->request->getPost('tanggal'),
            'waktu'       => $this->request->getPost('waktu'),
            'topik'       => $this->request->getPost('topik'),
            'status'      => 'belum',
        ];
        
        if ($this->jadwalModel->insert($data)) {
            return redirect()->to('/admin/jadwal')->with('success', 'Jadwal berhasil ditambahkan.');
        }
        
        return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan.');
    }
    
    public function edit($id)
    {
        $jadwal = $this->jadwalModel->find($id);
        
        if (!$jadwal) {
            return redirect()->to('/admin/jadwal')->with('error', 'Jadwal tidak ditemukan.');
        }
        
        $data = [
            'title'    => 'Edit Jadwal',
            'jadwal'   => $jadwal,
            'pengajar' => $this->userModel->getPengajar(),
        ];
        
        return view('admin/jadwal/edit', $data);
    }
    
    public function update($id)
    {
        $jadwal = $this->jadwalModel->find($id);
        
        if (!$jadwal) {
            return redirect()->to('/admin/jadwal')->with('error', 'Jadwal tidak ditemukan.');
        }
        
        $rules = [
            'pengajar_id' => 'required|integer',
            'tanggal'     => 'required|valid_date',
            'waktu'       => 'required',
            'topik'       => 'required|min_length[3]',
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'pengajar_id' => $this->request->getPost('pengajar_id'),
            'tanggal'     => $this->request->getPost('tanggal'),
            'waktu'       => $this->request->getPost('waktu'),
            'topik'       => $this->request->getPost('topik'),
        ];
        
        if ($this->jadwalModel->update($id, $data)) {
            return redirect()->to('/admin/jadwal')->with('success', 'Jadwal berhasil diperbarui.');
        }
        
        return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan.');
    }
    
    public function delete($id)
    {
        if ($this->jadwalModel->delete($id)) {
            return redirect()->to('/admin/jadwal')->with('success', 'Jadwal berhasil dihapus.');
        }
        
        return redirect()->back()->with('error', 'Terjadi kesalahan.');
    }
}
