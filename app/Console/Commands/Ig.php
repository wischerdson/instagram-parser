<?php

namespace App\Console\Commands;

use App\Services\Instagram\Client;
use App\Services\Instagram\Headers;
use App\Services\Instagram\InstagramFacade;
use App\Services\Instagram\Requests\FollowersRequest;
use App\Services\Instagram\Requests\UserInfoRequest;
use App\Services\Instagram\Responses\FollowersResponse;
use App\Services\Instagram\Responses\UserInfoResponse;
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
		$rawHeaders = <<<END
accept: */*
accept-encoding: gzip, deflate, br
accept-language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7
cookie: mid=Y-VMBQAEAAHwFZNm6Z0PSw_OZndG; ig_did=D7C212CA-A7DE-473E-B93A-993C372A310C; csrftoken=TDQ4zWewjszrMvqDmwWsfqstTcTU98vc; ds_user_id=58321755158; sessionid=58321755158%3AipKtNkvnOc5pUs%3A22%3AAYd7o99AvEBPNkTQZq5-J2FppDpfhHNGOK5BYAkJVA; dpr=2; datr=iE3lY5eeqpsBLA6lHmwhOdt-; rur="LDC\05458321755158\0541707666264:01f7b24829de67033fcc0c10b69b8305d65e98d77bb0f5fe44119ee00f403e99c56e95f3"
referer: https://www.instagram.com/ragebeat123/
sec-ch-prefers-color-scheme: dark
sec-ch-ua: "Not_A Brand";v="99", "Google Chrome";v="109", "Chromium";v="109"
sec-ch-ua-mobile: ?0
sec-ch-ua-platform: "macOS"
sec-fetch-dest: empty
sec-fetch-mode: cors
sec-fetch-site: same-origin
user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36
viewport-width: 1470
x-asbd-id: 198387
x-csrftoken: TDQ4zWewjszrMvqDmwWsfqstTcTU98vc
x-ig-app-id: 936619743392459
x-ig-www-claim: hmac.AR25gmKCyS9QSRR81NkrYvcmzP36fyWKmhBnQ4mgmiMh80tL
x-requested-with: XMLHttpRequest
END;

		$response = InstagramFacade::getUserInfo('36985831116', $rawHeaders);

		dd($response->user);


		// $headers = Headers::parse($rawHeaders);

		// $request = new FollowersRequest();
		// $request->authorize($headers);
		// $request->userPk = 31559053588;

		// $response = new FollowersResponse($client->send($request));

		// dd($response);

		// $model = $response->getModel();
		// $model->next_max_id;
		// $collection = $model->items;

		/* ================== */

		// $client = new InstagramClient();
		// $request = new UserInfoRequest();
		// $request->authorize($headers);
		// $request->userPk = 1907122774;

		// $response = new UserInfoResponse($client->send($request));

		// dd($response->user);

		// $request->authorize($accountHeaders);
		// $request->username = 'some_username';

		// $response = $client->send();


		return Command::SUCCESS;
	}
}
