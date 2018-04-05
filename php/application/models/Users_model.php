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
	 * register
	 *
	 * 利用者を登録・編集する
	 *
	 * @param array $data
	 * @return string|int $user_id
	 */
	public function register($data)
	{
		$user_id = $data['user_id'];
		$upsert = array(
			'user_id' => $data['user_id'],
			'nickname' => $data['nickname'],
			'email' => $data['email'],
		);
		if( $this->validation->required($data['password']) ){
			/* パスワードがある場合はハッシュ化 */
			$upsert['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
		}
		try{
			$this->db->trans_start();
			if( $user_id > 0 ){
				/* 編集 */
				$conditions = array(
					'user_id' => $user_id
				);
				$this->db->update($this->_table, $upsert, $conditions);
			}else{
				/* 新規登録 */
				$this->db->insert($this->_table, $upsert);
				$user_id = $this->db->insert_id();
			}
			$this->db->trans_complete();
		}catch(Exception $e){
			log_message('error', $e->getMessage());
			$this->db->trans_rollback();
		}
		return $user_id;
	}

	/**
	 * getList
	 *
	 * アカウントの一覧情報を取得
	 *
	 * @param array $search
	 * @return object|bool
	 */
	public function getList($search=false, $isCount=false)
	{
		$result = false;
		try{
			$select = array(
				'user_id',
				'email',
				'nickname',
			);
			$this->db->select($select);

			if($search && is_array($search)){
				foreach($search as $column => $value){
					switch ($column) {
						case 'email':
						case 'nickname':
							if( $this->validation->required($value) ){
								$this->db->like($column, $value);
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
	 * getDetail
	 *
	 * 利用者の詳細情報を取得
	 *
	 * @param string $user_id
	 * @return object|bool
	 */
	public function getDetail($user_id)
	{
		$result = false;
		try{
			$select = array(
				'user_id',
				'email',
				'nickname',
			);
			$this->db->select($select);

			$this->db->where('user_id', $user_id);
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
				'user_id',
				'password',
			);
			$conditions = array(
				'email' => $email
			);
			$result = $this->db->select($select)->where($conditions)->get($this->_table)->row();
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
