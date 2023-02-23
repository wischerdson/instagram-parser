<?php

namespace App\Console\Commands;

use App\Models\Worker;
use App\Services\TasksDispatcher;
use App\Services\WorkerHealthcheck;
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
		// $result = WorkerHealthcheck::check(Worker::find(1));
		// dd($result);
		TasksDispatcher::assignWork();

		return Command::SUCCESS;
	}
}
