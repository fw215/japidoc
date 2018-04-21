<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_CreateApis extends CI_Migration
{
	/**
	 * up
	 *
	 * apisテーブル作成
	 */
	public function up()
	{
		$fields = array(
			'api_id' => array(
				'type'           => 'bigint',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE,
				'comment'        => 'ApiID'
			),
			'project_id' => array(
				'type'           => 'bigint',
				'unsigned'       => TRUE,
				'comment'        => 'プロジェクトID'
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
				'comment'        => '説明'
			),
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_field('created datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT "登録日時"');
		$this->dbforge->add_field('modified datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "更新日時"');

		$this->dbforge->add_key('api_id', TRUE);
		$this->dbforge->create_table('apis');
	}

	/**
	 * down
	 *
	 * apisテーブル削除
	 */
	public function down()
	{
		$this->dbforge->drop_table('apis', TRUE);
	}
}