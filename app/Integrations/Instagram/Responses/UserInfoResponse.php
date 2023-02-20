<?php

namespace App\Integrations\Instagram\Responses;

use App\Integrations\Instagram\Models\User;
use App\Integrations\Instagram\Response;
use Illuminate\Support\Arr;

class UserInfoResponse extends Response
{
	public readonly string $status;

	public readonly User $user;

	protected function fill(array $data): void
	{
		$this->status = Arr::get($data, 'status');
		$this->user = new User(Arr::get($data, 'user', []));
	}
}
