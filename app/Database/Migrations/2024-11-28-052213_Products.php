<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Products extends Migration
{
    public function up()
    {
        // Creating the table
        $this->forge->addField([
            'id'            => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'name'          => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'collation'      => 'utf8mb4_general_ci',
            ],

            'slug'          => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'collation'      => 'utf8mb4_general_ci',
                'unique'         => true,
            ],

            'category_id'   => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
            ],

            'description'   => [
                'type'           => 'TEXT',
                'null'           => true
            ],

            'price'         => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],

            'stocks'         => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => 1
            ],

            'image'         => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'default'        => null
            ],

            'created_at'    => [
                'type'           => 'DATETIME',
                'default'         => null
            ],

            'updated_at'    => [
                'type'           => 'DATETIME',
                'default'        => null
            ]
        ]);
        $this->forge->addKey('id');
        $this->forge->createTable('products');
    }


    public function down()
    {
        $this->forge->dropTable('products', true);
    }
}
