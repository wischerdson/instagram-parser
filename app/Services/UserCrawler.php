<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserCrawler
{
	private readonly User $user;

	private readonly ?string $phone;

	private readonly ?string $email;

	public function __construct(User $user)
	{
		$this->user = $user;
		$this->phone = $this->tryToFetchPhone();
		$this->email = $this->getEmail();
	}

	public function tryToFetchPhone(): ?string
	{
		if ($this->user->public_phone_number && $this->user->public_phone_country_code) {
			return $this->user->public_phone_country_code . $this->user->public_phone_number;
		}

		if ($this->user->whatsapp_number) {
			return $this->user->whatsapp_number;
		}

		if ($this->user->contact_phone_number) {
			return $this->user->contact_phone_number;
		}

		if ($phone = $this->findPhone($this->user->bio)) {
			return $phone;
		}

		if ($phone = $this->findPhone($this->user->external_url)) {
			return $phone;
		}

		if ($phone = $this->findPhone($this->user->address_street)) {
			return $phone;
		}

		return null;
	}

	public function getEmail(): ?string
	{
		if (!($email = $this->user->public_email)) {
			return null;
		}

		if (Validator::make([$email], ['*' => 'email'])->fails()) {
			return null;
		}

		return mb_strtolower($email);
	}

	private function findPhone(string $string): ?string
	{
		preg_match('/(^|\D)(\+|8)[\s\d()-_]+/i', $string, $matches);

		if (!isset($matches[0])) {
			return null;
		}

		return $this->normalizePhone($matches[0]);
	}

	private function normalizePhone(string $dirtyPhone): string
	{
		$phone = preg_replace('/\D/', '', $dirtyPhone);
		$phone = preg_replace('/^8/', '7', $dirtyPhone);

		return $phone;
	}
}
