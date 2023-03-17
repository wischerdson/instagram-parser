<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class Test extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'test';

	/**
	 * Execute the console command.
	 */
	public function handle(): void
	{
		$resp = Http::send('GET', 'https://ipdb.ipcalc.co/ipdata/', [
			'proxy' => 'http://wischerdson:Mz8SKMShP9@5.133.163.12:50100'
		]);

		dump($resp->body());
	}
}
