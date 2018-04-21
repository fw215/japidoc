<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_CreateHeaders extends CI_Migration
{
	/**
	 * up
	 *
	 * headersテーブル作成
	 */
	public function up()
	{
		$fields = array(
			'header_id' => array(
				'type'           => 'bigint',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE,
				'comment'        => 'HTTPヘッダーID'
			),
			'api_id' => array(
				'type'           => 'bigint',
				'unsigned'       => TRUE,
				'comment'        => 'ApiID'
			),
			'name' => array(
				'type'           => 'varchar',
				'constraint'     => '255',
				'null'           => FALSE,
				'comment'        => '名称'
			),
			'value' => array(
				'type'           => 'text',
				'null'           => FALSE,
				'comment'        => '値'
			),
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_field('created datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT "登録日時"');
		$this->dbforge->add_field('modified datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "更新日時"');

		$this->dbforge->add_key('header_id', TRUE);
		$this->dbforge->create_table('headers');
	}

	/**
	 * down
	 *
	 * headersテーブル削除
	 */
	public function down()
	{
		$this->dbforge->drop_table('headers', TRUE);
	}
}