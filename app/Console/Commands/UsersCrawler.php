<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;

class UsersCrawler extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'users:crawl';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description';

	/**
	 * Execute the console command.
	 */
	public function handle()
	{

		// $swissNumberStr = "19156357451";
		// $phoneNumberUtil = PhoneNumberUtil::getInstance();
		// $asYouType = $phoneNumberUtil->getAsYouTypeFormatter('RU');
		// $asYouType->

		$phoneNumberUtil = \libphonenumber\PhoneNumberUtil::getInstance();

		$text = "Hi, can you ring me at 1430 on 0117 496 0123. Thanks!";

		$phoneNumberMatcher = $phoneNumberUtil->findNumbers($text, 'GB');

		foreach ($phoneNumberMatcher as $phoneNumberMatch) {
			var_dump($phoneNumberMatch->number());
		}
		// (PhoneNumber) Country Code: 44 National Number: 1174960123


		try {
			$phoneNumberObj = $phoneNumberUtil->parse($swissNumberStr, null);

			// $isValid = $phoneNumberUtil->isValidNumber($phoneNumberObj);

			// if ($isValid) {
				dd($phoneNumberObj);
			// }

		} catch (NumberParseException $e) {
			dd($e);
		}

		return Command::SUCCESS;
	}
}
