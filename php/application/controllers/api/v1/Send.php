<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Send
 *
 * API送信
 */
class Send extends MY_Controller
{
	function __construct()
	{
		parent::__construct(FALSE);
	}

	/**
	 * env
	 *
	 * 指定環境のAPI送信
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

		exec('php '.FCPATH.'..'.DS.ENVIRONMENT.'.php send env '.$env->env_id, $output, $result);
		$this->_api['result'] = json_decode($output[0], TRUE);
		$this->json();
	}
}
