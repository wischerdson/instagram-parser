<?php

namespace App\Models;

use App\Contracts\TaskResult;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property int $id
 * @property bool $big_list
 * @property int $page_size
 * @property string $next_max_id
 * @property bool $has_more
 * @property bool $should_limit_list_of_followers
 * @property int $status
 * @property string $created_at
 */
class TaskResultsOfFollowersFetching extends Model implements TaskResult
{
	use HasFactory;

	const UPDATED_AT = null;

	protected $table = 'task_results_of_followers_fetching';

	protected $guarded = [];

	public function task(): MorphOne
	{
		return $this->morphOne(Task::class, 'result');
	}

	public function followers(): HasMany
	{
		return $this->hasMany(Follower::class, 'result_id');
	}
}
