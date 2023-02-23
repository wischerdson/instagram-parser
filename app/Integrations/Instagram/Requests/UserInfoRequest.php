<?php

namespace App\Integrations\Instagram\Requests;

use App\Integrations\Instagram\Dto;
use App\Integrations\Instagram\Dto\UserInfoResponse;
use App\Integrations\Instagram\Request;
use Illuminate\Http\Client\Response;

class UserInfoRequest extends Request
{
	public string | int $userPk;

	protected string $method = 'GET';

	public function getUrl(): string
	{
		return "https://www.instagram.com/api/v1/users/{$this->userPk}/info/";
	}

	public function castToDto(Response $response): ?Dto
	{
		return new UserInfoResponse($response->json());
	}
}
