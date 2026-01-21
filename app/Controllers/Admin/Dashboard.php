<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\ModulModel;
use App\Models\JadwalModel;

class Dashboard extends BaseController
{
    protected $userModel;
    protected $modulModel;
    protected $jadwalModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->modulModel = new ModulModel();
        $this->jadwalModel = new JadwalModel();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Dashboard Admin',
            'total_users' => $this->userModel->where('role', 'user')->countAllResults(),
            'total_pengajar' => $this->userModel->where('role', 'pengajar')->countAllResults(),
            'total_modul' => $this->modulModel->countAll(),
            'total_jadwal' => $this->jadwalModel->countAll(),
            'recent_users' => $this->userModel->where('role', 'user')->orderBy('created_at', 'DESC')->limit(5)->findAll(),
            'upcoming_jadwal' => $this->jadwalModel->getJadwalWithPengajar(date('m'), date('Y')),
        ];
        
        return view('admin/dashboard', $data);
    }
}
