<?php

namespace App\Models\TaskResults;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * Модель результатов задачи по сбору детальной информации о пользователе
 *
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
class UserInfoFetchingResult extends Model
{
	use HasFactory;

	public function task(): MorphOne
	{
		return $this->morphOne(Task::class, 'result', 'result_type', 'result_id');
	}
}
