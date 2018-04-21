<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_CreateBodies extends CI_Migration
{
	/**
	 * up
	 *
	 * bodiesテーブル作成
	 */
	public function up()
	{
		$fields = array(
			'body_id' => array(
				'type'           => 'bigint',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE,
				'comment'        => 'ボディID'
			),
			'env_id' => array(
				'type'           => 'bigint',
				'unsigned'       => TRUE,
				'comment'        => '環境ID'
			),
			'body' => array(
				'type'           => 'text',
				'null'           => FALSE,
				'comment'        => 'ボディ'
			),
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_field('created datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT "登録日時"');
		$this->dbforge->add_field('modified datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "更新日時"');

		$this->dbforge->add_key('body_id', TRUE);
		$this->dbforge->create_table('bodies');
	}

	/**
	 * down
	 *
	 * bodiesテーブル削除
	 */
	public function down()
	{
		$this->dbforge->drop_table('bodies', TRUE);
	}
}