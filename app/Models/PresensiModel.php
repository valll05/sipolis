<?php

namespace App\Models;

use CodeIgniter\Model;

class PresensiModel extends Model
{
    protected $table            = 'presensi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'tanggal',
        'mood',
        'catatan'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get presensi by user
     */
    public function getByUser($userId)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('tanggal', 'DESC')
                    ->findAll();
    }

    /**
     * Get presensi for calendar (FullCalendar format) - only submitted
     */
    public function getCalendarEvents($userId)
    {
        $presensi = $this->where('user_id', $userId)->findAll();
        
        $events = [];
        foreach ($presensi as $p) {
            $events[] = [
                'id'        => $p['id'],
                'title'     => 'Daily check-in',
                'start'     => $p['tanggal'],
                'display'   => 'block',
                'classNames' => ['checkin-submitted'],
                'extendedProps' => [
                    'status'  => 'submitted',
                    'mood'    => $p['mood'],
                    'catatan' => $p['catatan'],
                ]
            ];
        }
        
        return $events;
    }

    /**
     * Check if already checked in today
     */
    public function hasCheckedIn($userId, $date = null)
    {
        $date = $date ?? date('Y-m-d');
        return $this->where('user_id', $userId)
                    ->where('tanggal', $date)
                    ->first();
    }

    /**
     * Record check-in
     */
    public function checkIn($userId, $mood, $catatan = null)
    {
        $today = date('Y-m-d');
        
        // Check if already checked in
        $existing = $this->hasCheckedIn($userId, $today);
        
        if ($existing) {
            // Update existing
            return $this->update($existing['id'], [
                'mood'    => $mood,
                'catatan' => $catatan,
            ]);
        }
        
        // Create new
        return $this->insert([
            'user_id' => $userId,
            'tanggal' => $today,
            'mood'    => $mood,
            'catatan' => $catatan,
        ]);
    }

    /**
     * Get streak (consecutive days)
     */
    public function getStreak($userId)
    {
        $presensi = $this->where('user_id', $userId)
                         ->orderBy('tanggal', 'DESC')
                         ->findAll();
        
        if (empty($presensi)) return 0;
        
        $streak = 0;
        $today = strtotime('today');
        $expectedDate = $today;
        
        foreach ($presensi as $p) {
            $pDate = strtotime($p['tanggal']);
            
            if ($pDate == $expectedDate) {
                $streak++;
                $expectedDate = strtotime('-1 day', $expectedDate);
            } else {
                break;
            }
        }
        
        return $streak;
    }

    /**
     * Get monthly stats
     */
    public function getMonthlyStats($userId, $month = null, $year = null)
    {
        $month = $month ?? date('m');
        $year = $year ?? date('Y');
        
        $presensi = $this->where('user_id', $userId)
                         ->where('MONTH(tanggal)', $month)
                         ->where('YEAR(tanggal)', $year)
                         ->findAll();
        
        $stats = [
            'total' => count($presensi),
            'great' => 0,
            'neutral' => 0,
            'bad' => 0,
        ];
        
        foreach ($presensi as $p) {
            $stats[$p['mood']]++;
        }
        
        return $stats;
    }
}
