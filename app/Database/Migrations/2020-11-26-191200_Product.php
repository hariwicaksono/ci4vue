<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Product extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'product_id' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
				'auto_increment' => true,
			],
			'product_name' => [
				'type' => 'VARCHAR',
				'constraint' => '100'
			],
			'product_price' => [
				'type' => 'INT',
				'constraint' => 11
			],
			'product_description' => [
				'type' => 'TEXT'
			],
			'product_image' => [
				'type' => 'INT',
				'constraint' => 11
			],
			'active' => [
				'type' => 'INT',
				'constraint' => 11
			]
		]);

		$this->forge->addKey('product_id', true);
		$this->forge->createTable('product');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('product');
	}
}
