<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property int $id
 * @property string $user_pk
 */
class TaskInputForUserInfoFetching extends Model
{
	use HasFactory;

	public $timestamps = false;

	protected $table = 'task_input_for_user_info_fetching';

	public function task(): MorphOne
	{
		return $this->morphOne(Task::class, 'input_data');
	}
}
