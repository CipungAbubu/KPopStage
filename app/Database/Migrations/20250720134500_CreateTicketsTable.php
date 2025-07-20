<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTicketsTable extends Migration
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
            'concert_id'  => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'category'   => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'price'      => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'stock'      => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'description' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            // Tambahkan ini ke dalam addField (setelah 'description')
'image' => [
    'type' => 'VARCHAR',
    'constraint' => 255,
    'null' => true,
],
            'created_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('concert_id', 'concerts', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tickets');
    }

    public function down()
    {
        $this->forge->dropTable('tickets');
    }
}
