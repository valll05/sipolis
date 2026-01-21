<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\ModulModel;
use App\Models\ProgressModel;

class Dashboard extends BaseController
{
    protected $modulModel;
    protected $progressModel;
    
    public function __construct()
    {
        $this->modulModel = new ModulModel();
        $this->progressModel = new ProgressModel();
    }
    
    public function index()
    {
        $userId = session()->get('user_id');
        
        $data = [
            'title'         => 'Dashboard',
            'stats'         => $this->progressModel->getUserStats($userId),
            'recent_modul'  => $this->modulModel->orderBy('created_at', 'DESC')->limit(6)->findAll(),
            'my_progress'   => $this->progressModel->getByUser($userId),
        ];
        
        return view('user/dashboard', $data);
    }
}
