<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Benchmarks
 *
 * ベンチマーク
 */
class Benchmarks extends MY_Controller
{
	function __construct()
	{
		parent::__construct(FALSE);
	}

	/**
	 * get
	 *
	 * 1件取得
	 */
	public function get($env_id=0, $benchmark_id=0)
	{
		$search = array(
			'env_id' => $env_id,
			'benchmark_id' => $benchmark_id,
		);

		$benchmark = $this->Benchmarks->get($search);
		if( !$benchmark ){
			show_404();
		}

		$benchmark->is_benchmarked = TRUE;
		if( $benchmark->average == 0 ){
			$benchmark->is_benchmarked = FALSE;
		}
		$this->_api['benchmark'] = $benchmark;

		$this->json();
	}

	/**
	 * post
	 *
	 * 1件登録
	 */
	public function post($env_id=0)
	{
		$insert = array(
			'env_id' => isset($this->_stream['env_id']) ? $this->space_trim($this->_stream['env_id']) : NULL,
			'times' => isset($this->_stream['times']) ? $this->space_trim($this->_stream['times']) : NULL,
		);
		$errors = $this->Benchmarks_lib->register_validation( $insert );
		if( $errors ){
			$this->_api['code'] = API_BAD_REQUEST;
			$this->_api['errors'] = $errors;
			$this->json();
		}

		$benchmark = $this->Benchmarks->insert($insert);
		if( !$benchmark ){
			show_404();
		}

		exec('php '.FCPATH.'..'.DS.ENVIRONMENT.'.php send bench '.$benchmark->benchmark_id.' > /dev/null &');

		$search = array(
			'env_id' => $env_id,
		);
		$benchmarks = $this->Benchmarks->search($search);

		$this->_api['benchmarks'] = $benchmarks;
		$this->json();
	}
}
