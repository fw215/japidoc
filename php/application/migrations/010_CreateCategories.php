<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_CreateCategories extends CI_Migration
{
	/**
	 * up
	 *
	 * Categoriesテーブル作成
	 */
	public function up()
	{
		$fields = array(
			'category_id' => array(
				'type'           => 'bigint',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE,
				'comment'        => 'カテゴリID'
			),
			'name' => array(
				'type'           => 'varchar',
				'constraint'     => '255',
				'null'           => FALSE,
				'comment'        => '名称'
			),
			'description' => array(
				'type'           => 'text',
				'null'           => FALSE,
				'comment'        => '概要'
			),
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_field('created datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT "登録日時"');
		$this->dbforge->add_field('modified datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "更新日時"');

		$this->dbforge->add_key('category_id', TRUE);
		$this->dbforge->create_table('categories');

		$sql = "INSERT INTO `categories` (`name`, `description`) VALUES ('本番環境', '');";
		$this->db->query($sql);
	}

	/**
	 * down
	 *
	 * categoriesテーブル削除
	 */
	public function down()
	{
		$this->dbforge->drop_table('categories', TRUE);
	}
}