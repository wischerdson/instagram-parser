<?php

namespace App\Models;

use App\Services\Instagram\Requests\Request;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property string $serialized_request_object
 * @property string $type
 * @property int $result_id
 * @property string $status
 * @property string $created_at
 * @property string $processed_at
 */
class Task extends Model
{
	use HasFactory;

	public function resultable(): MorphTo
	{
		return $this->morphTo(type: 'type', id: 'result_id');
	}

	protected function request(): Attribute
	{
		return Attribute::make(
			get: fn ($_, $attrs): Request => unserialize($attrs['serialized_request_object']),
			set: fn (Request $request) => ['serialized_request_object' => serialize($request)]
		);
	}
}
