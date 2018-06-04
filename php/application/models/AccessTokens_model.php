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
	 * @param int $type
	 * @return object|bool
	 */
	public function tryAutoLogin(string $token, int $type)
	{
		$result = false;
		try{
			$select = array(
				'access_tokens.user_id',
			);
			$conditions = array(
				'access_token' => $token,
				'expire_date >=' => date('Y-m-d H:i:s'),
				'type' => $type,
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
	 * fetchToken
	 *
	 * 指定のトークンを取得
	 *
	 * @param int $user_id
	 * @param int $type
	 * @return string|bool
	 */
	public function fetchToken(int $user_id, int $type)
	{
		$access_token = false;
		try{
			$select = array(
				'access_tokens.access_token',
			);
			$conditions = array(
				'access_tokens.user_id' => $user_id,
				'access_tokens.expire_date >=' => date('Y-m-d H:i:s'),
				'access_tokens.type' => $type,
			);
			$this->db->join('users', 'access_tokens.user_id = users.user_id');
			$result = $this->db->select($select)->where($conditions)->get($this->_table)->row();
			if( $result ){
				$access_token = $result->access_token;
			}
		}catch(Exception $e){
			log_message('error', $e->getMessage());
			return false;
		}
		return $access_token;
	}

	/**
	 * generateToken
	 *
	 * アクセストークンを生成する
	 *
	 * @param string $user_id
	 * @param int $type
	 * @return string|bool
	 */
	public function generateToken($user_id, $type)
	{
		$result = false;
		$access_token = random_string('alnum', 128);
		$expire_date = date('Y-m-d H:i:s', time() + ACCESS_EXPIRE_TIME);

		$insert = array(
			'user_id' => $user_id,
			'ip_address' => $this->input->ip_address(),
			'access_token' => $access_token,
			'expire_date' => $expire_date,
			'type' => $type
		);
		try{
			$this->db->trans_start();
			$result = $this->db->insert($this->_table, $insert);
			if( !$result ){
				$error = $this->db->error();
				/* 重複しているため再度トークンを発行 */
				if( $error['code'] === 1062 ){
					$this->generateToken($user_id, $type);
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
	 * アクセストークンを削除する
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
