<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Carts extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'user_id'   => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
            ],

            'product_id'   => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
            ],

            'quantity'   => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
            ],

            'subtotal'   => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
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

        $this->forge->addKey('id');
        $this->forge->createTable('carts');
    }

    public function down()
    {
        $this->forge->dropTable('carts', true);
    }
}
