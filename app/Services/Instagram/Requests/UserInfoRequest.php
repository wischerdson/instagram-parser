<?php

namespace App\Services\Instagram\Requests;

use App\Services\Instagram\Responses\FollowersResponse;
use Illuminate\Http\Client\Response;

class UserInfoRequest extends Request
{
	public string | int $userPk;

	public function getUrl(): string
	{
		return "https://www.instagram.com/api/v1/users/{$this->userPk}/info/";
	}

	public function getResponseInstance(Response $httpResponse): FollowersResponse
	{
		return new FollowersResponse($httpResponse);
	}
}
