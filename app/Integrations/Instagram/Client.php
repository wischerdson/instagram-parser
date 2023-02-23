<?php

namespace App\Integrations\Instagram;

use App\Integrations\Instagram\Request;
use App\Integrations\Instagram\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Client
{
	public static function send(Request $request): Response
	{
		if ($proxy = $request->getProxy() ?: []) {
			$proxy = ['proxy' => $proxy->getProxyUrl()];
		}

		try {
			$response = Http::send($request->getMethod(), $request->getUrl(), [
				'query' => $request->getQuery(),
				'data' => $request->getBody(),
				'headers' => $request->getHeaders()->toArray(),
				...$proxy
			]);
		} catch (\Throwable $th) {
			Log::critical($th->getMessage());
			$response = null;
		}

		return new Response($response, $request);
	}
}
