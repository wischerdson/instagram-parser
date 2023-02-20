<?php

namespace App\Integrations\Instagram\Models;

class Follower extends Model
{
	public string $pk;

	public string $pkId;

	public string $username;

	public string $fullName;

	public bool $isPrivate;

	public bool $isVerified;

	public string $profilePicUrl;

	public array $accountBadges;

	public int $latestReelMedia;
}
