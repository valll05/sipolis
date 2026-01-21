<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalModel extends Model
{
    protected $table            = 'jadwals';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'pengajar_id',
        'tanggal',
        'waktu',
        'topik',
        'status',
        'catatan'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'pengajar_id' => 'required|integer',
        'tanggal'     => 'required|valid_date',
        'waktu'       => 'required',
        'topik'       => 'required|min_length[3]',
    ];

    protected $skipValidation = false;

    /**
     * Get jadwal by pengajar
     */
    public function getByPengajar($pengajarId)
    {
        return $this->where('pengajar_id', $pengajarId)
                    ->orderBy('tanggal', 'ASC')
                    ->findAll();
    }

    /**
     * Get jadwal with pengajar info
     */
    public function getJadwalWithPengajar($month = null, $year = null)
    {
        $builder = $this->db->table('jadwals');
        $builder->select('jadwals.*, users.nama as pengajar_nama');
        $builder->join('users', 'users.id = jadwals.pengajar_id');
        
        if ($month && $year) {
            $builder->where('MONTH(tanggal)', $month);
            $builder->where('YEAR(tanggal)', $year);
        }
        
        $builder->orderBy('tanggal', 'ASC');
        return $builder->get()->getResultArray();
    }

    /**
     * Get jadwal for calendar (formatted for FullCalendar)
     */
    public function getForCalendar($pengajarId = null)
    {
        $builder = $this->db->table('jadwals');
        $builder->select('jadwals.*, users.nama as pengajar_nama');
        $builder->join('users', 'users.id = jadwals.pengajar_id');
        
        if ($pengajarId) {
            $builder->where('pengajar_id', $pengajarId);
        }
        
        $jadwals = $builder->get()->getResultArray();
        
        $events = [];
        foreach ($jadwals as $jadwal) {
            $events[] = [
                'id'    => $jadwal['id'],
                'title' => $jadwal['topik'] . ' - ' . $jadwal['pengajar_nama'],
                'start' => $jadwal['tanggal'] . 'T' . $jadwal['waktu'],
                'color' => $jadwal['status'] === 'selesai' ? '#198754' : '#dc3545',
                'extendedProps' => [
                    'pengajar'  => $jadwal['pengajar_nama'],
                    'status'    => $jadwal['status'],
                    'catatan'   => $jadwal['catatan'],
                ]
            ];
        }
        
        return $events;
    }

    /**
     * Update status jadwal
     */
    public function updateStatus($id, $status, $catatan = null)
    {
        $data = ['status' => $status];
        if ($catatan) {
            $data['catatan'] = $catatan;
        }
        return $this->update($id, $data);
    }

    /**
     * Get all jadwal with pengajar info
     */
    public function getAllWithPengajar()
    {
        $builder = $this->db->table('jadwals');
        $builder->select('jadwals.*, users.nama as pengajar_nama');
        $builder->join('users', 'users.id = jadwals.pengajar_id');
        $builder->orderBy('tanggal', 'DESC');
        return $builder->get()->getResultArray();
    }

    /**
     * Get upcoming jadwal (today and future)
     */
    public function getUpcoming($limit = 10)
    {
        $builder = $this->db->table('jadwals');
        $builder->select('jadwals.*, users.nama as pengajar_nama');
        $builder->join('users', 'users.id = jadwals.pengajar_id');
        $builder->where('tanggal >=', date('Y-m-d'));
        $builder->orderBy('tanggal', 'ASC');
        $builder->limit($limit);
        return $builder->get()->getResultArray();
    }
}
