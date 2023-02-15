<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property string $serialized_request_object
 * @property string $type
 * @property string $result_type
 * @property int $result_id
 * @property string $status
 * @property string $created_at
 * @property string $processed_at
 */
class Task extends Model
{
	use HasFactory;

	const UPDATED_AT = null;

	const TYPE_FOLLOWERS_FETCHING = 'followers_fetching';

	const TYPE_USER_INFO_FETCHING = 'user_info_fetching';

	const STATUS_UNPROCESSED = 'unprocessed';

	const STATUS_IN_PROCESS = 'in_process';

	const STATUS_PROCESSED = 'processed';

	const STATUS_FAILED = 'failed';

	/** Установить тип задачи - извлечение списка подписчиков */
	public function setFollowerFetchingType(): void
	{
		$this->type = self::TYPE_FOLLOWERS_FETCHING;
	}

	/** Установить тип задача - получение детально информации об instagram-пользователе */
	public function setUserInfoFetchingType(): void
	{
		$this->type = self::TYPE_USER_INFO_FETCHING;
	}

	public function setInProcessStatus(): void
	{
		$this->status = self::STATUS_IN_PROCESS;
	}

	public function result(): MorphTo
	{
		return $this->morphTo(type: 'result_type', id: 'result_id');
	}

	public function request(): MorphTo
	{
		return $this->morphTo(type: 'request_type', id: 'request_id');
	}

	public function scopeUnprocessed(Builder $query): void
	{
		$query->where('status', self::STATUS_UNPROCESSED);
	}

	public function worker(): BelongsTo
	{
		return $this->belongsTo(Worker::class, 'worker_id');
	}
}
