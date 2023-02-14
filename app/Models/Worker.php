<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
