<?php

namespace App\Console\Commands;

use App\Services\UserCrawler as UserCrawlerService;
use Illuminate\Console\Command;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
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
	 * Execute the console command.
	 */
	public function handle()
	{
		UserCrawlerService::run();

		return Command::SUCCESS;
	}
}
