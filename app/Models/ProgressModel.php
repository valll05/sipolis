<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgressModel extends Model
{
    protected $table            = 'progress';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'modul_id',
        'is_downloaded',
        'is_completed',
        'accessed_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $skipValidation = false;

    /**
     * Get progress by user
     */
    public function getByUser($userId)
    {
        $builder = $this->db->table('progress');
        $builder->select('progress.*, moduls.judul, moduls.kategori');
        $builder->join('moduls', 'moduls.id = progress.modul_id');
        $builder->where('progress.user_id', $userId);
        $builder->orderBy('progress.accessed_at', 'DESC');
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get or create progress record
     */
    public function getOrCreate($userId, $modulId)
    {
        $progress = $this->where('user_id', $userId)
                         ->where('modul_id', $modulId)
                         ->first();
        
        if (!$progress) {
            $this->insert([
                'user_id'     => $userId,
                'modul_id'    => $modulId,
                'accessed_at' => date('Y-m-d H:i:s'),
            ]);
            $progress = $this->find($this->getInsertID());
        }
        
        return $progress;
    }

    /**
     * Mark as downloaded
     */
    public function markDownloaded($userId, $modulId)
    {
        $progress = $this->getOrCreate($userId, $modulId);
        return $this->update($progress['id'], [
            'is_downloaded' => 1,
            'accessed_at'   => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Mark as completed
     */
    public function markCompleted($userId, $modulId)
    {
        $progress = $this->getOrCreate($userId, $modulId);
        return $this->update($progress['id'], [
            'is_completed' => 1,
            'accessed_at'  => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Get user statistics
     */
    public function getUserStats($userId)
    {
        $total = $this->db->table('moduls')->countAllResults();
        $downloaded = $this->where('user_id', $userId)
                           ->where('is_downloaded', 1)
                           ->countAllResults();
        $completed = $this->where('user_id', $userId)
                          ->where('is_completed', 1)
                          ->countAllResults();
        
        return [
            'total_modul'    => $total,
            'downloaded'     => $downloaded,
            'completed'      => $completed,
            'progress_percent' => $total > 0 ? round(($completed / $total) * 100) : 0,
        ];
    }

    /**
     * Get all progress for a user
     */
    public function getUserProgress($userId)
    {
        return $this->where('user_id', $userId)->findAll();
    }
}
