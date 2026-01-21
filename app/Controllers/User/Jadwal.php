<?php

namespace App\Controllers\User;

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
        $jadwals = $this->jadwalModel->getUpcoming();
        
        $data = [
            'title'   => 'Jadwal Konsultasi',
            'jadwals' => $jadwals,
        ];
        
        return view('user/jadwal/index', $data);
    }
    
    public function getEvents()
    {
        $jadwals = $this->jadwalModel->getAllWithPengajar();
        
        $events = [];
        foreach ($jadwals as $jadwal) {
            $events[] = [
                'id'          => $jadwal['id'],
                'title'       => $jadwal['topik'] . ' - ' . $jadwal['pengajar_nama'],
                'start'       => $jadwal['tanggal'],
                'color'       => $jadwal['status'] == 'selesai' ? '#22c55e' : '#f59e0b',
                'extendedProps' => [
                    'pengajar' => $jadwal['pengajar_nama'],
                    'waktu'    => $jadwal['waktu'],
                    'status'   => $jadwal['status'],
                ]
            ];
        }
        
        return $this->response->setJSON($events);
    }
}
