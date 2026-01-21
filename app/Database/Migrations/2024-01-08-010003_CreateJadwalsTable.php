<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJadwalsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'pengajar_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'waktu' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'topik' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['belum', 'selesai'],
                'default'    => 'belum',
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pengajar_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('jadwals');
    }

    public function down()
    {
        $this->forge->dropTable('jadwals');
    }
}
