<?php

namespace App\Services\Instagram;

use App\Services\Instagram\Requests\FollowersRequest;
use App\Services\Instagram\Requests\UserInfoRequest;
use App\Services\Instagram\Responses\FollowersResponse;
use App\Services\Instagram\Responses\UserInfoResponse;

class InstagramFacade
{
	public static function getUserFollowers(string | int $userPk, ?string $maxId = '', string $rawHeaders): FollowersResponse
	{
		$headers = Headers::parse($rawHeaders);

		$request = new FollowersRequest();
		$request->authorize($headers);
		$request->userPk = $userPk;
		$request->maxId = $maxId;

		return new FollowersResponse(Client::send($request));
	}

	public static function getUserInfo(string | int $userPk, string $rawHeaders): UserInfoResponse
	{
		$headers = Headers::parse($rawHeaders);

		$request = new UserInfoRequest();
		$request->authorize($headers);
		$request->userPk = $userPk;

		return new UserInfoResponse(Client::send($request));
	}
}
