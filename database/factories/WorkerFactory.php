<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Worker>
 */
class WorkerFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition()
	{
		return [
			'login' => fake()->userName(),
			'password' => fake()->password(),
			'headers' => <<<END
accept: */*
accept-encoding: gzip, deflate, br
accept-language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7
cookie: mid=Y-VMBQAEAAHwFZNm6Z0PSw_OZndG; ig_did=D7C212CA-A7DE-473E-B93A-993C372A310C; dpr=2; datr=iE3lY5eeqpsBLA6lHmwhOdt-; csrftoken=F02GN9trfjgz6V3BVCoXvNevNQOOISYr; ds_user_id=57978535592; sessionid=57978535592%3AsV33jbiOSVl0Py%3A27%3AAYfHJoYtOCcu1ZRiY9eLKV4GETFAWwwCwj6rOPc9zQ; rur="CLN\05457978535592\0541707933411:01f7032d2f53136c348bd6a380aa2270f43a9fdc2500fbdeefeefdeede0793e09ab834ce"
referer: https://www.instagram.com/gxbxcgyp/followers/
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
x-csrftoken: F02GN9trfjgz6V3BVCoXvNevNQOOISYr
x-ig-app-id: 936619743392459
x-ig-www-claim: hmac.AR15X2kZ2V1PWFpJ62QJcYJlBN6tPynL24ZvVwR4en389My-
x-requested-with: XMLHttpRequest
END,
			'status' => 'waiting',
			'last_request_at' => null,
			'sleeps_until' => null,
		];
	}
}
