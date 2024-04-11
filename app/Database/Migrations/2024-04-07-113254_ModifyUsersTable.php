<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyUsersTable extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('name', 'users')) {
            $this->forge->addColumn('users', [
                'name' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ],
            ]);
        }

        if ($this->db->fieldExists('username', 'users')) {
            $this->forge->dropColumn('users', 'username');
        }
    }

    public function down()
    {
        // Reverse the changes made in up method
        if (!$this->db->fieldExists('username', 'users')) {
            $this->forge->addColumn('users', [
                'username' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ],
            ]);
        }

        if ($this->db->fieldExists('name', 'users')) {
            $this->forge->dropColumn('users', 'name');
        }
    }
}
