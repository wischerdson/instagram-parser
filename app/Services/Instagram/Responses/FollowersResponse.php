<?php

namespace App\Services\Instagram\Responses;

use App\Services\Instagram\Models\FollowersCollection;
use Illuminate\Support\Arr;

class FollowersResponse extends Response
{
	public readonly ?bool $bigList;

	public readonly ?int $pageSize;

	public readonly ?string $nextMaxId;

	public readonly bool $hasMore;

	public readonly ?bool $shouldLimitListOfFollowers;

	public readonly string $status;

	public readonly FollowersCollection $followers;

	protected function fill(array $data): void
	{
		$this->bigList =                    Arr::get($data, 'big_list');
		$this->pageSize =                   Arr::get($data, 'page_size');
		$this->nextMaxId =                  Arr::get($data, 'next_max_id');
		$this->hasMore =                    Arr::get($data, 'has_more');
		$this->shouldLimitListOfFollowers = Arr::get($data, 'should_limit_list_of_followers');
		$this->status =                     Arr::get($data, 'status');
		$this->followers =                  new FollowersCollection(Arr::get($data, 'users', []));
	}
}
