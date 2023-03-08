<?php

namespace App\Services;

use App\Models\CrawledUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

class UserCrawler
{
	private readonly User $user;

	private readonly PhoneNumberUtil $phoneUtil;

	private readonly ?PhoneNumber $phone;

	private readonly ?string $email;

	public function __construct(User $user)
	{
		$this->user = $user;
		$this->phoneUtil = PhoneNumberUtil::getInstance();
		$this->phone = (new UserPhoneCrawler($this->phoneUtil, $user))->getPhone();
		$this->email = $this->getEmail();
	}

	public static function run(): void
	{
		$total = 0;

		User::doesntHave('crawled')->chunkById(1000, function (Collection $users) use (&$total) {
			$crawled = $users->map(function (User $user) {
				$crawler = new self($user);
				return ($model = $crawler->getFilledModel()) ? $model->toArray() : null;
			})->filter();

			$total += $crawled->count();

			CrawledUser::upsert($crawled->toArray(), ['phone']);
		});

		dump('Total crawled: ' . $total);
	}

	public function getFilledModel(): ?CrawledUser
	{
		$email = $this->email;
		$phone = $this->phone;

		if (!$email && !$phone) {
			return null;
		}

		$user = $this->user;

		$crawled = new CrawledUser();
		$crawled->ig_pk = $user->pk;
		$crawled->ig_username = $user->username;
		$crawled->ig_full_name = $user->full_name ?: null;
		$crawled->ig_biography = $user->biography ?: null;
		$crawled->ig_category = $user->category ?: null;
		$crawled->city = $user->city_name ?: null;
		$crawled->email = $email;
		$crawled->is_business = $user->is_business;

		if (!$phone) {
			$crawled->phone = null;
			$crawled->phone_country_code = null;
			$crawled->phone_national_number = null;
			$crawled->phone_region_code = null;

			return $crawled;
		}

		$crawled->phone = $this->phoneUtil->format($this->phone, PhoneNumberFormat::E164);
		$crawled->phone_country_code = $this->phone->getCountryCode();
		$crawled->phone_national_number = $this->phone->getNationalNumber();
		$crawled->phone_region_code = $this->phoneUtil->getRegionCodeForNumber($this->phone);

		return $crawled;
	}

	private function getEmail(): ?string
	{
		if (!($email = $this->user->public_email)) {
			return null;
		}

		if (Validator::make([$email], ['*' => 'email'])->fails()) {
			return null;
		}

		return mb_strtolower($email);
	}
}
