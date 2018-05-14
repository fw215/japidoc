<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forms_model extends CI_Model
{
	protected $_table;

	public function __construct() {
		parent::__construct();

		$this->_table = 'forms';
	}

	/**
	 * search
	 *
	 * 一覧情報を取得
	 *
	 * @param array $search
	 * @param bool $isCount
	 * @return object|bool
	 */
	public function search($search=false, $isCount=false)
	{
		$result = false;
		try{
			$select = array(
				'forms.form_id',
				'forms.env_id',
				'forms.name',
				'forms.value',
				'DATE_FORMAT(forms.created, "%Y/%m/%d") as created_ymd',
				'DATE_FORMAT(forms.created, "%Y/%m/%d %H:%i:%S") as created_ymd_his',
				'DATE_FORMAT(forms.modified, "%Y/%m/%d") as modified_ymd',
				'DATE_FORMAT(forms.modified, "%Y/%m/%d %H:%i:%S") as modified_ymd_his',
			);
			$this->db->select($select);

			if($search && is_array($search)){
				foreach($search as $column => $value){
					switch ($column) {
						case 'env_id':
							if( $this->validation->required($value) ){
								$this->db->where('env_id', $value);
							}
							break;
						case 'page':
							if( $isCount == false && $this->validation->required($value) ){
								if($value > 0){
									$offset = DEFAULT_PAGE_LIMIT * ($value - 1);
									$this->db->limit(DEFAULT_PAGE_LIMIT, $offset);
								}
							}
							break;
						default:
							break;
					}
				}
			}

			$this->db->order_by('forms.name', 'ASC');

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
				'forms.form_id',
				'forms.env_id',
				'forms.name',
				'forms.value',
				'DATE_FORMAT(forms.created, "%Y/%m/%d") as created_ymd',
				'DATE_FORMAT(forms.created, "%Y/%m/%d %H:%i:%S") as created_ymd_his',
				'DATE_FORMAT(forms.modified, "%Y/%m/%d") as modified_ymd',
				'DATE_FORMAT(forms.modified, "%Y/%m/%d %H:%i:%S") as modified_ymd_his',
			);
			$this->db->select($select);

			if($search && is_array($search)){
				foreach($search as $column => $value){
					switch ($column) {
						case 'form_id':
							$this->db->where('form_id', $value);
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
	 * update
	 *
	 * 1件更新
	 *
	 * @param int $form_id
	 * @param array $update
	 * @return object|bool
	 */
	public function update(int $form_id, array $update)
	{
		$result = false;
		try{
			$conditions = array(
				'form_id' => $form_id
			);
			$form = $this->get($conditions);
			if( !$form ){
				return false;
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
			if( $this->db->insert($this->_table, $insert) ){
				$conditions = array(
					'form_id' => $this->db->insert_id()
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
	 * @param int $form_id
	 * @return bool
	 */
	public function delete(int $form_id)
	{
		$result = false;
		try{
			$conditions = array(
				'form_id' => $form_id
			);
			$form = $this->get($conditions);
			if( !$form ){
				return false;
			}

			$result = $this->db->delete($this->_table, $conditions);
		}catch(Exception $e){
			log_message('error', $e->getMessage());
		}
		return $result;
	}

	/**
	 * eliminate
	 *
	 * 不要なFORMを削除
	 *
	 * @param int $env_id
	 * @param array $IDs
	 * @return array
	 */
	public function eliminate($env_id, $IDs=false)
	{
		$result = false;
		try{
			$this->db->select('form_id');
			$this->db->where('env_id', $env_id);
			if( $IDs ){
				$this->db->where_not_in('form_id', $IDs);
			}
			$forms = $this->db->get($this->_table)->result();
			if( $forms ){
				foreach($forms as $form){
					$result[] = $this->delete($form->form_id);
				}
			}

		}catch(Exception $e){
			log_message('error', $e->getMessage());
		}
		return $result;
	}
}
