<?php

namespace App\Integrations\Instagram\Requests;

use App\Integrations\Instagram\Request;

class UserInfoRequest extends Request
{
	public string | int $userPk;

	protected $method = 'GET';

	public function getUrl(): string
	{
		return "https://www.instagram.com/api/v1/users/{$this->userPk}/info/";
	}
}
