<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama',
        'email',
        'password',
        'program_studi',
        'universitas',
        'role',
        'foto'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'nama'     => 'required|min_length[3]|max_length[255]',
        'email'    => 'required|valid_email|is_unique[users.email,id,{id}]',
        'password' => 'required|min_length[6]',
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Email sudah terdaftar.',
        ],
    ];

    protected $skipValidation = false;

    /**
     * Get all pengajar
     */
    public function getPengajar()
    {
        return $this->where('role', 'pengajar')->findAll();
    }

    /**
     * Get all users (role = user)
     */
    public function getUsers()
    {
        return $this->where('role', 'user')->findAll();
    }

    /**
     * Verify login credentials
     */
    public function verifyLogin($email, $password)
    {
        $user = $this->where('email', $email)->first();
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
}
