<?php

namespace App\Services;

use App\Models\User;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberUtil;

class UserPhoneCrawler
{
	private readonly User $user;

	private readonly ?PhoneNumber $phone;

	private readonly PhoneNumberUtil $phoneUtil;

	public function __construct(PhoneNumberUtil $phoneUtil, User $user)
	{
		$this->user = $user;
		$this->phoneUtil = $phoneUtil;
		$this->phone = $this->getPhoneObject();
	}

	public function getPhone(): ?PhoneNumber
	{
		return $this->phone;
	}

	private function getPhoneObject(): ?PhoneNumber
	{
		$phone = $this->tryToFetchPhone();

		try {
			return $this->phoneUtil->parse($phone, 'RU');
		} catch (\Exception $e) {
			return null;
		}
	}

	private function tryToFetchPhone(): ?string
	{
		if ($this->user->contact_phone_number) {
			return $this->user->contact_phone_number;
		}

		if ($this->user->public_phone_number && $this->user->public_phone_country_code) {
			return '+' . $this->user->public_phone_country_code . $this->user->public_phone_number;
		}

		if ($this->user->whatsapp_number) {
			return $this->user->whatsapp_number;
		}

		if ($phone = $this->recognizePhone($this->user->bio)) {
			return $phone;
		}

		if ($phone = $this->recognizePhone($this->user->external_url)) {
			return $phone;
		}

		if ($phone = $this->recognizePhone($this->user->address_street)) {
			return $phone;
		}

		return null;
	}

	private function recognizePhone(?string $string): ?string
	{
		$phoneNumberMatcher = $this->phoneUtil->findNumbers($string, 'RU');

		foreach ($phoneNumberMatcher as $phoneNumberMatch) {
			$phone = $phoneNumberMatch->number();

			if ($phone) {
				$phone->getRawInput();
			}
		}

		return null;
	}
}
