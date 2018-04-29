<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_CreateAccessTokens extends CI_Migration
{
	/**
	 * up
	 *
	 * access_tokensテーブル作成
	 */
	public function up()
	{
		$fields = array(
			'access_token' => array(
				'type'           => 'char',
				'constraint'     => '128',
				'unique'         => TRUE,
				'null'           => FALSE,
				'comment'        => 'アクセストークン'
			),
			'user_id' => array(
				'type'           => 'bigint',
				'unsigned'       => TRUE,
				'comment'        => '利用者ID'
			),
			'ip_address' => array(
				'type'           => 'varchar',
				'constraint'     => '15',
				'comment'        => 'IPアドレス'
			),
			'expire_date' => array(
				'type'           => 'datetime',
				'null'           => FALSE,
				'comment'        => 'アクセス期限'
			),
			'type' => array(
				'type'           => 'int',
				'unsigned'       => TRUE,
				'null'           => FALSE,
				'comment'        => 'トークンタイプ'
			),
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_field('created datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT "登録日時"');
		$this->dbforge->add_field('modified datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "更新日時"');

		$this->dbforge->add_key('access_token', TRUE);
		$this->dbforge->create_table('access_tokens');
	}

	/**
	 * down
	 *
	 * access_tokensテーブル削除
	 */
	public function down()
	{
		$this->dbforge->drop_table('access_tokens', TRUE);
	}
}