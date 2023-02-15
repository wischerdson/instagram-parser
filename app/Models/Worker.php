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

	protected $fillable = ['login', 'password', 'headers'];

	public function scopeFree(Builder $query): void
	{
		$query->where('status', self::STATUS_READY_TO_WORK);
	}

	public function tasks(): HasMany
	{
		return $this->hasMany(Task::class, 'worker_id');
	}

	public function deactivate(): void
	{
		$this->status = self::STATUS_INACTIVE;
		$this->save();
	}

	public function currentTask(): HasOne
	{
		return $this->hasOne(Task::class, 'worker_id')->ofMany(aggregate: function (Builder $query) {
			$query->where('status', Task::STATUS_IN_PROCESS);
		});
	}
}
