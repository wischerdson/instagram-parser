<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $result_id
 * @property string $pk
 * @property string $username
 * @property string $full_name
 * @property bool $is_private
 * @property bool $is_verified
 * @property string $profile_pic_url
 */
class Follower extends Model
{
	use HasFactory;

	public $timestamps = false;

	protected $table = 'followers';

	public function result(): BelongsTo
	{
		return $this->belongsTo(TaskInputForFollowersFetching::class, 'result_id');
	}
}
