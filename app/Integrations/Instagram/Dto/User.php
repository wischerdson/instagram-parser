<?php

namespace App\Integrations\Instagram\Dto;

use App\Integrations\Instagram\Dto;

class User extends Dto
{
	public ?string $whatsappNumber;

	public ?string $externalUrl;

	public ?string $biography;

	public ?string $cityName;

	public ?string $category;

	public ?string $fullName;

	public ?string $username;

	public ?string $pk;

	public ?string $publicPhoneNumber;

	public ?string $publicPhoneCountryCode;

	public ?string $publicEmail;

	public ?string $contactPhoneNumber;

	public ?string $addressStreet;

	public ?bool $isBusiness;

	protected function fill(): void
	{
		$this->whatsappNumber         = $this->get('whatsapp_number');
		$this->externalUrl            = $this->get('external_url');
		$this->biography              = $this->get('biography');
		$this->cityName               = $this->get('city_name');
		$this->category               = $this->get('category');
		$this->fullName               = $this->get('full_name');
		$this->username               = $this->get('username');
		$this->pk                     = $this->get('pk');
		$this->publicPhoneNumber      = $this->get('public_phone_number');
		$this->publicPhoneCountryCode = $this->get('public_phone_country_code');
		$this->publicEmail            = $this->get('public_email');
		$this->contactPhoneNumber     = $this->get('contact_phone_number');
		$this->addressStreet          = $this->get('address_street');
		$this->isBusiness             = ($tmp = $this->get('is_business')) === null ? null : (bool) $tmp;
	}
}
