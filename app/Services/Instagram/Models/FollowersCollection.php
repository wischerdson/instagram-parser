<?php

namespace App\Services\Instagram\Models;

use ArrayIterator;
use Traversable;

class FollowersCollection extends ModelCollection
{
	/** @var \App\Services\Instagram\Models\Follower[] $followers */
	private array $followers = [];

	public function __construct(array $followers)
	{
		foreach ($followers as $follower) {
			$this->followers[] = new Follower($follower);
		}
	}

	public function getIterator(): Traversable
	{
		return new ArrayIterator($this->followers);
	}
}
