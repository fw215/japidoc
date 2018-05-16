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
		switch( $env->method ){
			case ENV_METHOD_GET:
				$curl->get($env->url);
				break;
			case ENV_METHOD_POST:
				$curl->post($env->url);
				break;
			case ENV_METHOD_PUT:
				$curl->put($env->url);
				break;
			case ENV_METHOD_DELETE:
				$curl->delete($env->url);
				break;
		}

		$response = array(
			'error_code' => $curl->errorCode,
			'error_message' => $curl->errorMessage,
			'response' => $curl->response,
		);
		echo json_encode($response);
	}
}
