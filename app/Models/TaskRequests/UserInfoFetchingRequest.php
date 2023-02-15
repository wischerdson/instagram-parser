<?php

namespace App\Models\TaskRequests;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property int $id
 * @property string $user_pk
 */
class UserInfoFetchingRequest extends Model implements IRequest
{
	use HasFactory;

	public $timestamps = false;

	public function task(): MorphOne
	{
		return $this->morphOne(Task::class, 'request', 'request_type', 'request_id');
	}
}
