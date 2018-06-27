<?php

class Envs_test extends TestCase
{
	public function setUp()
	{
		$this->resetInstance();

		$this->CI->load->library('migration');
		$this->CI->migration->version(0);
		$this->CI->migration->latest();

		$models = array(
			'Apis_model' => 'Apis',
			'Envs_model' => 'Envs',
			'Headers_model' => 'Headers',
			'Forms_model' => 'Forms',
		);
		$this->CI->load->model($models);
	}

	/**
	 * @test
	 */
	public function search()
	{
		$result = $this->CI->Envs->search();
		$this->assertEmpty($result);
	}

	/**
	 * @test
	*/
	public function get()
	{
		$result = $this->CI->Envs->get();
		$this->assertNull($result);
	}

	/**
	 * @test
	*/
	public function update()
	{
		$data = array();
		$result = $this->CI->Envs->update(0, $data);
		$this->assertFalse($result);
	}

	/**
	 * @test
	*/
	public function insert()
	{
		$data = array('name' => 'name');
		$api = $this->CI->Apis->insert($data);

		$data = array('api_id' => $api->api_id);
		$result = $this->CI->Envs->insert($data);
		$this->assertEquals($api->api_id, $result->api_id);
	}

	/**
	 * @test
	*/
	public function put()
	{
		$data = array('name' => 'name');
		$api = $this->CI->Apis->insert($data);

		$data = array('api_id' => $api->api_id);
		$result = $this->CI->Envs->insert($data);
		$this->assertEquals($api->api_id, $result->api_id);

		$header = array(
			'env_id' => $result->env_id,
			'name' => 'name',
			'value' => 'value',
		);
		$result_header = $this->CI->Headers->insert($header);
		$this->assertEquals(1, $result_header->header_id);

		$form = array(
			'env_id' => $result->env_id,
			'name' => 'name',
			'value' => 'value',
		);
		$result_form = $this->CI->Forms->insert($form);
		$this->assertEquals(1, $result_form->form_id);
	}
}
