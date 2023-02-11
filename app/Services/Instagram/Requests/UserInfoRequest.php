<?php

namespace App\Services\Instagram\Requests;

class UserInfoRequest extends Request
{
	public string | int $userPk;

	public function getUrl(): string
	{
		return "https://www.instagram.com/api/v1/users/{$this->userPk}/info/";
	}

	public function getMethod(): string
	{
		return 'GET';
	}
}
