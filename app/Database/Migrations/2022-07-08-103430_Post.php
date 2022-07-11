<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Forum extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'post_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'post_title' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'post_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'post_status' => [
                'type' => 'INT',
                'constraint' => 1,
                'null' => true,
            ],
            'post_user_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => true,
            ],
            'post_created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'post_updated_at DATETIME DEFAULT CURRENT_TIMESTAMP',
        ]);
        $this->forge->addKey('post_id', true);
        $this->forge->createTable('post');
    }

    public function down()
    {
        $this->forge->dropTable('post');
    }
}
