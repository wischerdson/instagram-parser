<?php

namespace App\Integrations\Instagram\Requests;

use App\Integrations\Instagram\Dto;
use App\Integrations\Instagram\Dto\FollowersResponse;
use App\Integrations\Instagram\Request;
use Illuminate\Http\Client\Response;

class FollowersRequest extends Request
{
	public string | int $userPk;

	public ?string $maxId;

	public int $count = 200;

	public string $searchSurface = 'follow_list_page';

	protected $method = 'GET';

	public function getUrl(): string
	{
		return "https://www.instagram.com/api/v1/friendships/{$this->userPk}/followers/";
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

	public function castToDto(Response $response): ?Dto
	{
		return new FollowersResponse($response->json());
	}
}
