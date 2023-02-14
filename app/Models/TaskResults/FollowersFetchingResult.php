<?php

namespace App\Models\TaskResults;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * Модель результатов задачи по сбору подписчиков
 *
 * @property int $id
 * @property string $pk
 * @property string $username
 * @property string $full_name
 * @property bool $is_private
 * @property bool $is_verified
 * @property string $profile_pic_url
 */
class FollowersFetchingResult extends Model
{
	use HasFactory;

	public function task(): MorphOne
	{
		return $this->morphOne(Task::class, 'result', 'result_type', 'result_id');
	}
}
