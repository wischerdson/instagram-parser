<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $worker_id
 * @property int $task_id
 * @property string $url
 * @property string $method
 * @property string $query
 * @property string $body
 * @property string $headers
 * @property string $response_headers
 * @property string $response_body
 * @property int $http_code
 * @property string $created_at
 */
class RequestLog extends Model
{
	use HasFactory;

	const UPDATED_AT = null;

	protected $table = 'requests_logs';

	public function worker(): BelongsTo
	{
		return $this->belongsTo(Worker::class, 'worker_id');
	}

	public function task(): BelongsTo
	{
		return $this->belongsTo(Task::class, 'task_id');
	}

	protected function requestQuery(): Attribute
	{
		return Attribute::make(
			get: fn (string $_, array $attrs) => json_decode($attrs['query']),
			set: fn (array $value) => ['query' => json_encode($value)]
		);
	}

	protected function body(): Attribute
	{
		return Attribute::make(
			get: fn (string $value) => $value ? unserialize($value) : null,
			set: fn (mixed $value) => $value ? serialize($value) : null
		);
	}

	protected function responseHeaders(): Attribute
	{
		return Attribute::make(
			get: fn (string $value) => json_decode($value),
			set: fn (mixed $value) => json_encode($value)
		);
	}

	protected function responseBody(): Attribute
	{
		return Attribute::make(
			set: fn (mixed $value) => substr($value, 0, min(mb_strlen($value, 'ascii'), 64*1024 - 1))
		);
	}
}
