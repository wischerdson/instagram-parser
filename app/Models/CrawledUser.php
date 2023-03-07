<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $ig_pk
 * @property string $ig_login
 * @property string $ig_full_name
 * @property string $ig_biography
 * @property string $ig_category
 * @property string $city
 * @property string $email
 * @property string $phone
 * @property bool $is_business
 * @property string $created_at
 */
class CrawledUser extends Model
{
	use HasFactory;

	const UPDATED_AT = null;

	protected $table = 'crawled_users';

	protected $guarded = [];

	public function parsedUser(): BelongsTo
	{
		return $this->belongsTo(User::class, 'ig_pk', 'pk');
	}
}
