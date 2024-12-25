<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
    {
        // Create table 'users'
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
            'email'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'collation'      => 'utf8mb4_general_ci',
                'unique'         => true,
            ],
            'password'    => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'collation'      => 'utf8mb4_general_ci',
            ],
            'role'        => [
                'type'           => 'ENUM',
                'constraint'     => ['admin', 'member'],
                'default'        => 'member',  // Default value for role
            ],
            'is_active'   => [
                'type'           => 'TINYINT',
                'constraint'     => 1,
                'default'        => 1,
            ],
            'image'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'collation'      => 'utf8mb4_general_ci',
                'null'           => true,
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
        $this->forge->createTable('users');
    }

    public function down()
    {
        // Drop the 'users' table if it exists
        $this->forge->dropTable('users');
    }
}
