<?php

namespace App\Models;

use App\Contracts\TaskResult;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property int $id
 * @property string $pk
 * @property string $username
 * @property string $full_name
 * @property string $biography
 * @property string $external_url
 * @property string $city_name
 * @property string $category
 * @property string $whatsapp_number
 * @property string $contact_phone_number
 * @property string $public_phone_number
 * @property int $public_phone_country_code
 * @property string $public_email
 * @property string $address_street
 * @property bool $is_business
 * @property string $created_at
 */
class User extends Model implements TaskResult
{
	use HasFactory;

	const UPDATED_AT = null;

	protected $table = 'users';

	protected $guarded = [];

	public function task(): MorphOne
	{
		return $this->morphOne(Task::class, 'result');
	}

	public function crawled(): HasOne
	{
		return $this->hasOne(CrawledUser::class, 'ig_pk', 'pk');
	}
}
