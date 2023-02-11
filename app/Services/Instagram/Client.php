<?php

namespace App\Services\Instagram;

use App\Services\Instagram\Requests\Request;
use Illuminate\Support\Facades\Http;

class Client
{
	public static function send(Request $request)
	{
		$httpResponse = Http::send($request->getMethod(), $request->getUrl(), [
			'query' => $request->getQuery(),
			'data' => $request->getBody(),
			'headers' => $request->getHeaders()->toArray()
		]);

		$response = $request->getResponseInstance($httpResponse);

		return $response;
	}
}
