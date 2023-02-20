<?php

namespace App\Integrations\Instagram\Dto;

use App\Integrations\Instagram\Dto;

class Follower extends Dto
{
	public string $pk;

	public ?string $pkId;

	public ?string $username;

	public ?string $fullName;

	public bool $isPrivate;

	public bool $isVerified;

	public ?string $profilePicUrl;

	public array $accountBadges;

	public ?int $latestReelMedia;

	protected function fill(): void
	{
		$this->pk              = $this->get('pk');
		$this->pkId            = $this->get('pk_id');
		$this->username        = $this->get('username');
		$this->fullName        = $this->get('full_name');
		$this->isPrivate       = (bool) $this->get('is_private');
		$this->isVerified      = (bool) $this->get('is_verified');
		$this->profilePicUrl   = $this->get('profile_pic_url');
		$this->accountBadges   = (array) $this->get('account_badges', default: []);
		$this->latestReelMedia = ($tmp = $this->get('latest_reel_media')) === null ? null : (int) $tmp;
	}
}
