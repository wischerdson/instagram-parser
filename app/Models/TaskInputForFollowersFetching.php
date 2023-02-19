<?php

namespace App\Models;

use App\Contracts\TaskInputData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property int $id
 * @property ?string $max_id
 * @property string $user_pk
 */
class TaskInputForFollowersFetching extends Model implements TaskInputData
{
	use HasFactory;

	public $timestamps = false;

	protected $table = 'task_input_for_followers_fetching';

	public function task(): MorphOne
	{
		return $this->morphOne(Task::class, 'input_data');
	}
}
