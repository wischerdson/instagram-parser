<?php

namespace App\Services\Instagram\Responses;

use App\Services\Instagram\Models\User;
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
