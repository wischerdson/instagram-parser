<?php

namespace App\Services\Instagram\Requests;

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

	public function getMethod(): string
	{
		return 'GET';
	}

	public function getQuery(): array
	{
		$out = [
			'count' => $this->count,
			'search_surface' => $this->searchSurface
		];

		if ($this->maxId) {
			$out['max_id'] = $this->maxId;
		}

		return $out;
	}
}
