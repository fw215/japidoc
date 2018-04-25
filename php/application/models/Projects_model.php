<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects_model extends CI_Model
{
	protected $_table;

	public function __construct() {
		parent::__construct();

		$this->_table = 'projects';
	}

	/**
	 * getList
	 *
	 * 一覧情報を取得
	 *
	 * @param array $search
	 * @param bool $isCount
	 * @return object|bool
	 */
	public function getList($search=false, $isCount=false)
	{
		$result = false;
		try{
			$select = array(
				'projects.project_id',
				'projects.name',
				'projects.description',
				'DATE_FORMAT(projects.created, "%Y/%m/%d") as created_ymd',
				'DATE_FORMAT(projects.created, "%Y/%m/%d %H:%i:%S") as created_ymd_his',
			);
			$this->db->select($select);

			if($search && is_array($search)){
				foreach($search as $column => $value){
					switch ($column) {
						case 'page':
							if( $isCount == false && $this->validation->required($value) ){
								$offset = DEFAULT_PAGE_LIMIT * ($value - 1);
								$this->db->limit(DEFAULT_PAGE_LIMIT, $offset);
							}
							break;
						default:
							break;
					}
				}
			}

			$this->db->order_by('projects.name', 'ASC');

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
}
