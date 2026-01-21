<?php

namespace App\Controllers\Pengajar;

use App\Controllers\BaseController;
use App\Models\JadwalModel;

class Dashboard extends BaseController
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
            'title'          => 'Dashboard Pengajar',
            'jadwals'        => $this->jadwalModel->getByPengajar($pengajarId),
            'total_jadwal'   => $this->jadwalModel->where('pengajar_id', $pengajarId)->countAllResults(),
            'jadwal_selesai' => $this->jadwalModel->where('pengajar_id', $pengajarId)->where('status', 'selesai')->countAllResults(),
        ];
        
        return view('pengajar/dashboard', $data);
    }
}
