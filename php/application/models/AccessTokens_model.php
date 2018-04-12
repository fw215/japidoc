<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AccessTokens_model extends CI_Model
{
	protected $_table;

	public function __construct() {
		parent::__construct();

		$this->_table = 'access_tokens';
	}

	/**
	 * tryAutoLogin
	 *
	 * 自動ログインを試みる
	 *
	 * @param string $token
	 * @return object|bool
	 */
	public function tryAutoLogin($token)
	{
		$result = false;
		try{
			$select = array(
				'access_tokens.user_id',
			);
			$conditions = array(
				'access_token' => $token,
				'access_expire >=' => date('Y-m-d H:i:s'),
			);
			$this->db->join('users', 'access_tokens.user_id = users.user_id');
			$result = $this->db->select($select)->where($conditions)->get($this->_table)->row();
		}catch(Exception $e){
			log_message('error', $e->getMessage());
			return false;
		}
		return $result;
	}

	/**
	 * generateToken
	 *
	 * ログイントークンを生成する
	 *
	 * @param string $user_id
	 * @return string|bool
	 */
	public function generateToken($user_id)
	{
		$result = false;
		$access_token = random_string('alnum', 128);
		$access_expire = date('Y-m-d H:i:s', time() + ACCESS_EXPIRE_TIME);

		$insert = array(
			'user_id' => $user_id,
			'ip_address' => $this->input->ip_address(),
			'access_token' => $access_token,
			'access_expire' => $access_expire,
		);
		try{
			$this->db->trans_start();
			$result = $this->db->insert($this->_table, $insert);
			if( !$result ){
				$error = $this->db->error();
				/* 重複しているため再度トークンを発行 */
				if( $error['code'] === 1062 ){
					$this->generateToken($user_id);
				}
			}
			$this->db->trans_complete();
		}catch(Exception $e){
			log_message('error', $e->getMessage());
			$this->db->trans_rollback();
			return false;
		}
		return $insert['access_token'];
	}

	/**
	 * deleteToken
	 *
	 * ログイントークンを削除する
	 *
	 * @param string $access_token
	 * @return bool
	 */
	public function deleteToken($access_token)
	{
		$conditions = array(
			'access_token' => $access_token
		);
		try{
			$this->db->trans_start();
			$result = $this->db->delete($this->_table, $conditions);
			$this->db->trans_complete();
		}catch(Exception $e){
			log_message('error', $e->getMessage());
			$this->db->trans_rollback();
			return false;
		}
		return true;
	}
}
