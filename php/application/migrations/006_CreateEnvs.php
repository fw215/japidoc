<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_CreateEnvs extends CI_Migration
{
	/**
	 * up
	 *
	 * envsテーブル作成
	 */
	public function up()
	{
		$fields = array(
			'env_id' => array(
				'type'           => 'bigint',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE,
				'comment'        => '環境ID'
			),
			'api_id' => array(
				'type'           => 'bigint',
				'unsigned'       => TRUE,
				'comment'        => 'ApiID'
			),
			'category_id' => array(
				'type'           => 'bigint',
				'unsigned'       => TRUE,
				'comment'        => 'カテゴリID'
			),
			'description' => array(
				'type'           => 'text',
				'null'           => FALSE,
				'comment'        => '概要'
			),
			'method' => array(
				'type'           => 'int',
				'unsigned'       => TRUE,
				'null'           => FALSE,
				'comment'        => 'METHOD'
			),
			'url' => array(
				'type'           => 'varchar',
				'constraint'     => '255',
				'null'           => FALSE,
				'comment'        => 'URL'
			),
			'body' => array(
				'type'           => 'text',
				'null'           => FALSE,
				'comment'        => 'BODY'
			),
			'is_body' => array(
				'type'           => 'int',
				'unsigned'       => TRUE,
				'null'           => FALSE,
				'comment'        => 'BODYの利用'
			),
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_field('created datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT "登録日時"');
		$this->dbforge->add_field('modified datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "更新日時"');

		$this->dbforge->add_key('env_id', TRUE);
		$this->dbforge->create_table('envs');
	}

	/**
	 * down
	 *
	 * envsテーブル削除
	 */
	public function down()
	{
		$this->dbforge->drop_table('envs', TRUE);
	}
}