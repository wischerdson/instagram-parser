<?php

namespace App\Services\Instagram\Responses;

use App\Services\Instagram\Models\Follower;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class FollowersResponse extends Response
{
	public readonly ?bool $bigList;

	public readonly ?int $pageSize;

	public readonly ?string $nextMaxId;

	public readonly bool $hasMore;

	public readonly ?bool $shouldLimitListOfFollowers;

	public readonly string $status;

	/** @var \Illuminate\Support\Collection<\App\Services\Instagram\Models\Follower> $followers */
	public readonly Collection $followers;

	protected function fill(array $data): void
	{
		$this->bigList = Arr::get($data, 'big_list');
		$this->pageSize = Arr::get($data, 'page_size');
		$this->nextMaxId = Arr::get($data, 'next_max_id');
		$this->hasMore = Arr::get($data, 'has_more');
		$this->shouldLimitListOfFollowers = Arr::get($data, 'should_limit_list_of_followers');
		$this->status = Arr::get($data, 'status');
		$this->followers = collect(Arr::get($data, 'users', []))->transform(
			fn (array $user) => new Follower($user)
		);
	}
}
