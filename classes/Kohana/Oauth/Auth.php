<?php
/**
*
*/
class Kohana_Oauth_Auth
{
	// Current User Jam Object
	public $user = null;

	public function __construct($server, $request, $responce, $token = null)
	{
		$this->server = $server;
		$this->request = $request;
		$this->responce = $responce;
		$this->token = $token;

		$this->setUser();
	}

	private function setUser()
	{
		$user_id = Arr::get($this->token, 'user_id');

		if (!$this->token || !$user_id)
		{
			return false;
		}

		$this->user = Jam::find('User', $user_id);
	}

	public function logged_in()
	{
		if ($this->user)
		{
			return true;
		}

		return false;
	}

	public function get_user()
	{
		return $this->user->as_array();
	}

	public function force_login($user_email)
	{
		$user = Jam::all('User')->where('email', '=', $user_email)->first();
		if (!$user)
		{
			return false;
		}

		$this->user = $user;
		return true;
	}
}
