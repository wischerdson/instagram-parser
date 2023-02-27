<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string $headers
 * @property string $status
 * @property string $last_request_at
 * @property string $sleeps_until
 * @property string $created_at
 */
class Worker extends Model
{
	use HasFactory;

	const UPDATED_AT = null;

	/** Воркер готов к работе */
	const STATUS_READY_TO_WORK = 'ready_to_work';

	/** Воркер что-то обрабатывает */
	const STATUS_BUSY = 'busy';

	/** Последний запрос вернул ошибку */
	const STATUS_INACTIVE = 'inactive';

	protected $table = 'workers';

	protected $fillable = ['login', 'password', 'headers', 'proxy', 'status'];

	public function tasks(): HasMany
	{
		return $this->hasMany(Task::class, 'worker_id');
	}

	public function currentTask(): HasOne
	{
		return $this->hasOne(Task::class, 'worker_id')->ofMany([], aggregate: function (Builder $query) {
			$query->where('status', Task::STATUS_IN_PROCESS);
		});
	}

	public function lastTask(): HasOne
	{
		return $this->hasOne(Task::class, 'worker_id')->ofMany(['processed_at' => 'max'], aggregate: function (Builder $query) {
			$query->where('status', Task::STATUS_PROCESSED);
		});
	}

	public function lastRequestLog(): HasOne
	{
		return $this->hasOne(RequestLog::class, 'worker_id')->ofMany('created_at');
	}

	public function requestLogs(): HasMany
	{
		return $this->hasMany(RequestLog::class, 'worker_id');
	}

	public function scopeFree(Builder $query): void
	{
		$query->where('status', self::STATUS_READY_TO_WORK);
	}

	public function deactivate(): void
	{
		$this->status = self::STATUS_INACTIVE;
		$this->save();
	}

	public function release(): void
	{
		$this->status = self::STATUS_READY_TO_WORK;
		$this->save();
	}

	public function loadWithTask(): void
	{
		$this->status = self::STATUS_BUSY;
		$this->save();
	}
}
