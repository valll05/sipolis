<?php

namespace App\Controllers\Pengajar;

use App\Controllers\BaseController;
use App\Models\JadwalModel;

class Jadwal extends BaseController
{
    protected $jadwalModel;
    
    public function __construct()
    {
        $this->jadwalModel = new JadwalModel();
    }
    
    public function index()
    {
        $pengajarId = session()->get('user_id');
        
        $data = [
            'title'   => 'Jadwal Saya',
            'jadwals' => $this->jadwalModel->getByPengajar($pengajarId),
        ];
        
        return view('pengajar/jadwal/index', $data);
    }
    
    public function getEvents()
    {
        $pengajarId = session()->get('user_id');
        $events = $this->jadwalModel->getForCalendar($pengajarId);
        return $this->response->setJSON($events);
    }
    
    public function updateStatus($id)
    {
        $pengajarId = session()->get('user_id');
        $jadwal = $this->jadwalModel->where('id', $id)->where('pengajar_id', $pengajarId)->first();
        
        if (!$jadwal) {
            return redirect()->back()->with('error', 'Jadwal tidak ditemukan.');
        }
        
        $status = $this->request->getPost('status');
        $catatan = $this->request->getPost('catatan');
        
        if ($this->jadwalModel->updateStatus($id, $status, $catatan)) {
            return redirect()->back()->with('success', 'Status jadwal berhasil diperbarui.');
        }
        
        return redirect()->back()->with('error', 'Terjadi kesalahan.');
    }
}
