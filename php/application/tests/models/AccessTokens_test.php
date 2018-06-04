<?php

class AccessTokens_test extends TestCase
{
	public function setUp()
	{
		$this->resetInstance();

		$this->CI->load->library('migration');
		$this->CI->migration->version(0);
		$this->CI->migration->latest();

		$models = array(
			'Users_model' => 'Users',
			'AccessTokens_model' => 'AccessTokens',
		);
		$this->CI->load->model($models);
	}

	/**
	 * @test
	 */
	public function all()
	{
		$data = array('password' => 'password');
		$createUser = $this->CI->Users->insert($data);

		$access_token = $this->CI->AccessTokens->generateToken($createUser->user_id, ACCESS_TOKEN_API);
		$this->assertInternalType('string', $access_token);

		$fetch_token = $this->CI->AccessTokens->fetchToken($createUser->user_id, ACCESS_TOKEN_API);
		$this->assertEquals($access_token, $fetch_token);

		$user = $this->CI->AccessTokens->tryAutoLogin($access_token, ACCESS_TOKEN_API);
		$this->assertEquals(1, $user->user_id);

		$result = $this->CI->AccessTokens->deleteToken($access_token);
		$this->assertTrue($result);
	}
}
