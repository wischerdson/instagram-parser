<?php

namespace App\Integrations\Instagram\Dto;

use App\Integrations\Instagram\Dto;
use Illuminate\Support\Collection;

class FollowersResponse extends Dto
{
	public ?bool $bigList;

	public ?int $pageSize;

	public ?string $nextMaxId;

	public bool $hasMore;

	public ?bool $shouldLimitListOfFollowers;

	public string $status;

	public Collection $followers;

	protected function fill(): void
	{
		$this->bigList                    = $this->get('big_list');
		$this->pageSize                   = $this->get('page_size');
		$this->nextMaxId                  = $this->get('next_max_id');
		$this->hasMore                    = $this->get('has_more');
		$this->shouldLimitListOfFollowers = $this->get('should_limit_list_of_followers');
		$this->status                     = $this->get('status');

		$this->followers = collect($this->get('users', default: []))->transform(
			fn (array $user) => new Follower($user)
		);
	}

	public function toArray(): array
	{
		return [
			'big_list'                       => $this->bigList,
			'page_size'                      => $this->pageSize,
			'next_max_id'                    => $this->nextMaxId,
			'has_more'                       => $this->hasMore,
			'should_limit_list_of_followers' => $this->shouldLimitListOfFollowers,
			'status'                         => $this->status
		];
	}
}
