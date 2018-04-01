<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_CreateUsers extends CI_Migration
{
	/**
	 * up
	 *
	 * usersテーブル作成
	 */
	public function up()
	{
		$fields = array(
			'user_id' => array(
				'type'           => 'bigint',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE,
				'comment'        => '利用者ID'
			),
			'email' => array(
				'type'           => 'varchar',
				'constraint'     => '255',
				'null'           => FALSE,
				'comment'        => 'メールアドレス(ログインID)'
			),
			'password' => array(
				'type'           => 'TEXT',
				'null'           => FALSE,
				'comment'        => 'パスワード'
			),
			'nickname' => array(
				'type'           => 'varchar',
				'constraint'     => '255',
				'null'           => FALSE,
				'comment'        => 'ニックネーム'
			),
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_field('created datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT "登録日時"');
		$this->dbforge->add_field('modified datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "更新日時"');

		$this->dbforge->add_key('user_id', TRUE);
		$this->dbforge->create_table('users');

		// INDEX
		$sql = "CREATE INDEX `index_users_login` ON `users`(`email`)";
		$this->db->query($sql);
	}

	/**
	 * down
	 *
	 * usersテーブル削除
	 */
	public function down()
	{
		$this->dbforge->drop_table('users', TRUE);
	}
}