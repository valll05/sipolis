<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateModulsTable extends Migration
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
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'kategori' => [
                'type'       => 'ENUM',
                'constraint' => ['sosial', 'produksi', 'distribusi', 'neraca'],
                'default'    => 'sosial',
            ],
            'file_pdf' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'ukuran_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'pengajar_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
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
        $this->forge->addForeignKey('pengajar_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('moduls');
    }

    public function down()
    {
        $this->forge->dropTable('moduls');
    }
}
