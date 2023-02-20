<?php

namespace App\Integrations\Instagram\Dto;

use App\Integrations\Instagram\Dto;

class UserInfoResponse extends Dto
{
	public string $status;

	public User $user;

	protected function fill(): void
	{
		$this->status = $this->get('status');
		$this->user   = new User($this->get('user'));
	}

	public function toArray(): array
	{
		return ['status' => $this->status];
	}
}
