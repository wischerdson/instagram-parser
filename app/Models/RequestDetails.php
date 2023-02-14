<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
class RequestDetails extends Model
{
	use HasFactory;
}
