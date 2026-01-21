<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        $this->db->table('users')->insert([
            'nama'     => 'Administrator',
            'email'    => 'admin@bps.go.id',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'role'     => 'admin',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        
        // Create sample pengajar
        $this->db->table('users')->insert([
            'nama'     => 'Dr. Ahmad Statistik',
            'email'    => 'pengajar@bps.go.id',
            'password' => password_hash('pengajar123', PASSWORD_DEFAULT),
            'role'     => 'pengajar',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        
        // Create sample user
        $this->db->table('users')->insert([
            'nama'          => 'Mahasiswa Demo',
            'email'         => 'user@demo.com',
            'password'      => password_hash('user123', PASSWORD_DEFAULT),
            'program_studi' => 'Statistika',
            'universitas'   => 'Universitas Riau',
            'role'          => 'user',
            'created_at'    => date('Y-m-d H:i:s'),
        ]);
        
        echo "Initial data seeded successfully!\n";
        echo "Admin: admin@bps.go.id / admin123\n";
        echo "Pengajar: pengajar@bps.go.id / pengajar123\n";
        echo "User: user@demo.com / user123\n";
    }
}
