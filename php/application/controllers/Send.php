<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Curl\Curl;
/**
 * Send
 *
 * send
 */
class Send extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		/**
		 * HTTPアクセスを抑止
		 */
		if( !$this->input->is_cli_request() ) {
			show_404();
			exit;
		}
	}

	/**
	 * env
	 *
	 * @param int $env_id
	 */
	public function env(int $env_id=NULL)
	{
		$search = array(
			'env_id' => $env_id,
		);
		$env = $this->Envs->get($search);
		if( !$env ){
			show_404();
		}
		$headers = $this->Headers->search($search);
		$forms = $this->Forms->search($search);

		$curl = new Curl();
		if( $headers ){
			foreach($headers as $header){
				$curl->setHeader($header->name, $header->value);
			}
		}
		$data = array();
		if( $env->is_body == ENV_IS_BODY ){
			if( $this->validation->is_json($env->body) ){
				$data = json_decode($env->body);
			}
		}else{
			if( $forms ){
				foreach($forms as $form){
					$data[ $form->name ] = $form->value;
				}
			}
		}
		switch( $env->method ){
			case ENV_METHOD_GET:
				$curl->get($env->url);
				break;
			case ENV_METHOD_POST:
				if( $data ){
					$curl->post($env->url, $data);
				}else{
					$curl->post($env->url);
				}
				break;
			case ENV_METHOD_PUT:
				if( $data ){
					$curl->put($env->url, $data);
				}else{
					$curl->put($env->url);
				}
				break;
			case ENV_METHOD_DELETE:
				$curl->delete($env->url);
				break;
		}

		$response = array(
			'url' => $env->url,
			'error_code' => $curl->errorCode,
			'error_message' => $curl->errorMessage,
			'status_code' => $curl->httpStatusCode,
			'response_headers' => $curl->responseHeaders,
			'response_body' => $curl->response,
		);
		echo json_encode($response);
	}

	/**
	 * bench
	 *
	 * @param int $benchmark_id
	 */
	public function bench(int $benchmark_id=NULL)
	{
		$search = array(
			'benchmark_id' => $benchmark_id,
		);
		$benchmark = $this->Benchmarks->get($search);
		if( !$benchmark ){
			show_404();
		}

		$search = array(
			'env_id' => $benchmark->env_id,
		);
		$env = $this->Envs->get($search);
		if( !$env ){
			show_404();
		}
		$headers = $this->Headers->search($search);
		$forms = $this->Forms->search($search);

		$curl = new Curl();
		if( $headers ){
			foreach($headers as $header){
				$curl->setHeader($header->name, $header->value);
			}
		}
		$data = array();
		if( $env->is_body == ENV_IS_BODY ){
			if( $this->validation->is_json($env->body) ){
				$data = json_decode($env->body);
			}
		}else{
			if( $forms ){
				foreach($forms as $form){
					$data[ $form->name ] = $form->value;
				}
			}
		}

		$bench = array();
		switch( $env->method ){
			case ENV_METHOD_GET:
				for($time = 0; $time < $benchmark->times; $time++){
					$startTime = microtime(true);
					$curl->get($env->url);
					$endTime = microtime(true);
					$bench[] = $endTime - $startTime;
				}
				break;
			case ENV_METHOD_POST:
				for($time = 0; $time < $benchmark->times; $time++){
					$startTime = microtime(true);
					if( $data ){
						$curl->post($env->url, $data);
					}else{
						$curl->post($env->url);
					}
					$endTime = microtime(true);
					$bench[] = $endTime - $startTime;
				}
				break;
			case ENV_METHOD_PUT:
				for($time = 0; $time < $benchmark->times; $time++){
					$startTime = microtime(true);
					if( $data ){
						$curl->put($env->url, $data);
					}else{
						$curl->put($env->url);
					}
					$endTime = microtime(true);
					$bench[] = $endTime - $startTime;
				}
				break;
			case ENV_METHOD_DELETE:
				for($time = 0; $time < $benchmark->times; $time++){
					$startTime = microtime(true);
					$curl->delete($env->url);
					$endTime = microtime(true);
					$bench[] = $endTime - $startTime;
				}
				break;
		}

		asort($bench);
		$longest = end($bench);
		$shortest = reset($bench);
		$update = array(
			'longest' => $longest,
			'shortest' => $shortest,
			'average' => array_sum($bench) / count($bench),
		);
		$this->Benchmarks->update($benchmark_id, $update);
	}
}
