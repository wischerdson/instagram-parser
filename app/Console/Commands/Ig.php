<?php

namespace App\Console\Commands;

use App\Services\TasksDispatcher;
use Illuminate\Console\Command;

class Ig extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'ig:run';

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle()
	{
		TasksDispatcher::assignWork();

		return Command::SUCCESS;
	}
}
