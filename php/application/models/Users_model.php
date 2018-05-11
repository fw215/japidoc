<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model
{
	protected $_table;

	public function __construct() {
		parent::__construct();

		$this->_table = 'users';
	}

	/**
	 * search
	 *
	 * アカウントの一覧情報を取得
	 *
	 * @param array $search
	 * @return object|bool
	 */
	public function search($search=false, $isCount=false)
	{
		$result = false;
		try{
			$select = array(
				'users.user_id',
				'users.email',
				'users.nickname',
			);
			$this->db->select($select);

			if($search && is_array($search)){
				foreach($search as $column => $value){
					switch ($column) {
						case 'email':
						case 'nickname':
							if( $this->validation->required($value) ){
								$this->db->like('users.'.$column, $value);
							}
							break;
						default:
							break;
					}
				}
			}

			if( $isCount === true ){
				$result = $this->db->from($this->_table)->count_all_results();
			}else{
				$result = $this->db->get($this->_table)->result();
			}
		}catch(Exception $e){
			log_message('error', $e->getMessage());
		}
		return $result;
	}

	/**
	 * get
	 *
	 * 1件取得
	 *
	 * @param array $search
	 * @return object|bool
	 */
	public function get($search=false)
	{
		$result = false;
		try{
			$select = array(
				'users.user_id',
				'users.email',
				'users.nickname',
			);
			$this->db->select($select);

			if($search && is_array($search)){
				foreach($search as $column => $value){
					switch ($column) {
						case 'user_id':
							$this->db->where('users.user_id', $value);
							break;
						default:
							break;
					}
				}
			}

			$result = $this->db->get($this->_table)->row();
		}catch(Exception $e){
			log_message('error', $e->getMessage());
		}
		return $result;
	}

	/**
	 * getDataEmail
	 *
	 * ログイン時のパスワードをチェック
	 * パスワードのチェックにはpassword_verifyを利用
	 *
	 * @param string $email
	 * @return object|bool
	 */
	public function getDataEmail($email)
	{
		$result = false;
		try{
			$select = array(
				'users.user_id',
				'users.password',
			);
			$conditions = array(
				'users.email' => $email
			);
			$result = $this->db->select($select)->where($conditions)->get($this->_table)->row();
		}catch(Exception $e){
			log_message('error', $e->getMessage());
		}
		return $result;
	}

	/**
	 * update
	 *
	 * 1件更新
	 *
	 * @param int $user_id
	 * @param array $update
	 * @return object|bool
	 */
	public function update(int $user_id, array $update)
	{
		$result = false;
		try{
			$conditions = array(
				'users.user_id' => $user_id
			);
			$project = $this->get($conditions);
			if( !$project ){
				return false;
			}

			if( $this->validation->required($update['password']) ){
				/* パスワードがある場合はハッシュ化 */
				$update['password'] = password_hash($update['password'], PASSWORD_DEFAULT);
			}
			if( $this->db->update($this->_table, $update, $conditions) ){
				$result = $this->get($conditions);
			}
		}catch(Exception $e){
			log_message('error', $e->getMessage());
		}
		return $result;
	}

	/**
	 * passwordResetting
	 *
	 * パスワードを再設定する
	 *
	 * @param string|int $upsert
	 * @param string|null $password
	 * @return string|int $user_id
	 */
	public function passwordResetting($user_id, $password=null)
	{
		$conditions = array(
			'user_id' => $user_id
		);
		if( $password === NULL ){
			/* NULLの場合はパスワードを削除 */
			$update['password'] = '';
		}else{
			/* パスワードをハッシュ化 */
			$update['password'] = password_hash($password, PASSWORD_DEFAULT);
		}
		try{
			$this->db->trans_start();
			$this->db->update($this->_table, $update, $conditions);
			$this->db->trans_complete();
		}catch(Exception $e){
			log_message('error', $e->getMessage());
			$this->db->trans_rollback();
		}
		return $user_id;
	}

	/**
	 * insert
	 *
	 * 1件登録
	 *
	 * @param array $insert
	 * @return object|bool
	 */
	public function insert(array $insert)
	{
		$result = false;
		try{
			$insert['password'] = password_hash($insert['password'], PASSWORD_DEFAULT);
			if( $this->db->insert($this->_table, $insert) ){
				$conditions = array(
					'user_id' => $this->db->insert_id()
				);
				$result = $this->get($conditions);
			}
		}catch(Exception $e){
			log_message('error', $e->getMessage());
		}
		return $result;
	}

	/**
	 * delete
	 *
	 * 1件削除
	 *
	 * @param int $user_id
	 * @return bool
	 */
	public function delete(int $user_id)
	{
		$result = false;
		try{
			$conditions = array(
				'user_id' => $user_id
			);
			$project = $this->get($conditions);
			if( !$project ){
				return false;
			}

			$result = $this->db->delete($this->_table, $conditions);
		}catch(Exception $e){
			log_message('error', $e->getMessage());
		}
		return $result;
	}

	/**
	 * isCheckDuplicateEmail
	 *
	 * Emailが既に登録されているかチェック
	 *
	 * @param string $email
	 * @param int $user_id
	 * @return bool
	 */
	public function isCheckDuplicateEmail($email, $user_id)
	{
		try{
			$select = array(
				'user_id',
			);
			$conditions = array(
				'email' => $email,
				'user_id !=' => $user_id
			);
			$user = $this->db->select($select)->where($conditions)->get($this->_table)->row();
			if($user){
				return true;
			}
		}catch(Exception $e){
			log_message('error', $e->getMessage());
		}
		return false;
	}

}
