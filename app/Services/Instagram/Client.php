<?php

namespace App\Services\Instagram;

use App\Services\Instagram\Requests\Request;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Client
{
	public static function send(Request $request): ?Response
	{
		try {
			return Http::send($request->getMethod(), $request->getUrl(), [
				'query' => $request->getQuery(),
				'data' => $request->getBody(),
				'headers' => $request->getHeaders()->toArray()
			]);
		} catch (\Throwable $th) {
			Log::critical($th->getMessage());
			return null;
		}
	}
}
