<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Ig extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'ig';

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle()
	{
		$client = new InstagramClient();

		$credentials = new AuthCredentials($accountHeaders);

		$request = new FollowersRequest();
		$request->authorize($credentials);
		$request->maxId = 'asd';
		$request->userPk = 12523423;

		$response = $client->send($request);

		if ($response->isSomethingWrong()) {
			throw ...;
		}

		$model = $response->getModel();
		$model->next_max_id;
		$collection = $model->items;

		/* ================== */

		$client = new InstagramClient();
		$request = new UserInfoRequest();
		$request->authorize($accountHeaders);
		$request->username = 'some_username';

		$response = $client->send();


		return Command::SUCCESS;
	}
}
