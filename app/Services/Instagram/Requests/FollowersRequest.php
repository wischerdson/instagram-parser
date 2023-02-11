<?php

namespace App\Services\Instagram\Requests;

use App\Services\Instagram\Responses\FollowersResponse;
use Illuminate\Http\Client\Response;

class FollowersRequest extends Request
{
	public string | int $userPk;

	public string $maxId = '';

	public int $count = 200;

	public string $searchSurface = 'follow_list_page';

	public function getUrl(): string
	{
		return "https://www.instagram.com/api/v1/friendships/{$this->userPk}/followers/";
	}

	public function getQuery(): array
	{
		return [
			'count' => $this->count,
			'max_id' => $this->maxId,
			'search_surface' => $this->searchSurface
		];
	}

	public function getResponseInstance(Response $httpResponse): FollowersResponse
	{
		return new FollowersResponse($httpResponse);
	}
}
