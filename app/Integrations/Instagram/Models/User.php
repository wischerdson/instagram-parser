<?php

namespace App\Integrations\Instagram\Models;

class User extends Model
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

	public int | string | null $publicPhoneCountryCode;

	public ?string $publicEmail;

	public ?string $contactPhoneNumber;

	public ?string $addressStreet;

	public ?bool $isBusiness;
}
