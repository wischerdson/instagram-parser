<?php

namespace App\Models;

use App\Models\TaskResults\FollowersFetchingResult;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Follower extends Model
{
	use HasFactory;

	public $timestamps = false;

	public function result(): BelongsTo
	{
		return $this->belongsTo(FollowersFetchingResult::class, 'followers_fetching_result_id');
	}
}
