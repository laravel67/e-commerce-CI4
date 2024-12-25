<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Categories extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name'        => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'collation'      => 'utf8mb4_general_ci',
            ],
            'slug'        => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'collation'      => 'utf8mb4_general_ci',
                'unique'         => true,
            ],
            'created_at'  => [
                'type'           => 'DATETIME',
                'null'           => null
            ],
            'updated_at'  => [
                'type'           => 'DATETIME',
                'null'           => null
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('categories');
    }

    public function down()
    {
        $this->forge->dropTable('categories', true);
    }
}
