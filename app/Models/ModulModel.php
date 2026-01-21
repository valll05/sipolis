<?php

namespace App\Models;

use CodeIgniter\Model;

class ModulModel extends Model
{
    protected $table            = 'moduls';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'judul',
        'deskripsi',
        'kategori',
        'file_pdf',
        'ukuran_file',
        'pengajar_id'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'judul'    => 'required|min_length[3]|max_length[255]',
        'kategori' => 'required|in_list[sosial,produksi,distribusi,neraca]',
    ];

    protected $skipValidation = false;

    /**
     * Get moduls by kategori
     */
    public function getByKategori($kategori)
    {
        return $this->where('kategori', $kategori)->findAll();
    }

    /**
     * Get modul with pengajar info
     */
    public function getModulWithPengajar($id = null)
    {
        $builder = $this->db->table('moduls');
        $builder->select('moduls.*, users.nama as pengajar_nama');
        $builder->join('users', 'users.id = moduls.pengajar_id', 'left');
        
        if ($id) {
            $builder->where('moduls.id', $id);
            return $builder->get()->getRowArray();
        }
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get kategori counts
     */
    public function getKategoriCounts()
    {
        return $this->select('kategori, COUNT(*) as total')
                    ->groupBy('kategori')
                    ->findAll();
    }
}
