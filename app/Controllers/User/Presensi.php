<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\PresensiModel;
use App\Models\JadwalModel;

class Presensi extends BaseController
{
    protected $presensiModel;
    protected $jadwalModel;
    
    public function __construct()
    {
        $this->presensiModel = new PresensiModel();
        $this->jadwalModel = new JadwalModel();
    }
    
    public function index()
    {
        $userId = session()->get('user_id');
        
        $data = [
            'title'         => 'Kalender Aktivitas',
            'streak'        => $this->presensiModel->getStreak($userId),
            'monthly_stats' => $this->presensiModel->getMonthlyStats($userId),
            'today_checkin' => $this->presensiModel->hasCheckedIn($userId),
            'jadwals'       => $this->jadwalModel->getUpcoming(5),
        ];
        
        return view('user/presensi/index', $data);
    }
    
    /**
     * Get events for FullCalendar (AJAX) - includes both presensi and jadwal
     */
    public function getEvents()
    {
        $userId = session()->get('user_id');
        
        // Get presensi events
        $presensiEvents = $this->presensiModel->getCalendarEvents($userId);
        
        // Get jadwal events
        $jadwals = $this->jadwalModel->getAllWithPengajar();
        $jadwalEvents = [];
        foreach ($jadwals as $jadwal) {
            $jadwalEvents[] = [
                'id'          => 'jadwal_' . $jadwal['id'],
                'title'       => '📅 ' . $jadwal['topik'],
                'start'       => $jadwal['tanggal'],
                'color'       => $jadwal['status'] == 'selesai' ? '#22c55e' : '#3b82f6',
                'textColor'   => '#ffffff',
                'extendedProps' => [
                    'type'     => 'jadwal',
                    'pengajar' => $jadwal['pengajar_nama'],
                    'waktu'    => $jadwal['waktu'],
                    'status'   => $jadwal['status'],
                ]
            ];
        }
        
        // Merge both event types
        $allEvents = array_merge($presensiEvents, $jadwalEvents);
        
        return $this->response->setJSON($allEvents);
    }
    
    /**
     * Process check-in
     */
    public function checkIn()
    {
        $userId = session()->get('user_id');
        $mood = $this->request->getPost('mood');
        $catatan = $this->request->getPost('catatan');
        
        if (!in_array($mood, ['bad', 'neutral', 'great'])) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'message' => 'Mood tidak valid.']);
            }
            return redirect()->back()->with('error', 'Mood tidak valid.');
        }
        
        if ($this->presensiModel->checkIn($userId, $mood, $catatan)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => true, 'message' => 'Check-in berhasil! 🎉']);
            }
            return redirect()->back()->with('success', 'Check-in berhasil! 🎉');
        }
        
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Terjadi kesalahan.']);
        }
        return redirect()->back()->with('error', 'Terjadi kesalahan.');
    }
    
    /**
     * Get check-in data for a specific date (AJAX)
     */
    public function getByDate($date)
    {
        $userId = session()->get('user_id');
        $presensi = $this->presensiModel->where('user_id', $userId)
                                        ->where('tanggal', $date)
                                        ->first();
        
        return $this->response->setJSON([
            'success' => true,
            'data' => $presensi
        ]);
    }
}
