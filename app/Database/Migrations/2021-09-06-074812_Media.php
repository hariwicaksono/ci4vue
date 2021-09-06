<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Media extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'media_id' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
				'auto_increment' => true,
			],
			'media_path' => [
				'type' => 'VARCHAR',
				'constraint' => '255'
			],
		]);

		$this->forge->addKey('media_id', true);
		$this->forge->createTable('media');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('media');
	}
}
