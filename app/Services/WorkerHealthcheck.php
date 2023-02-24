<?php

namespace App\Services;

use App\Integrations\Instagram\Headers;
use App\Integrations\Instagram\Requests\RecentSearchesRequest;
use App\Models\Worker;

class WorkerHealthcheck
{
	public static function check(Worker $worker): bool
	{
		$request = new RecentSearchesRequest();
		$headers = Headers::parse($worker->headers);

		$request->authorize($headers);
		$response = $request->send()->httpResponse;

		RequestLogger::log($worker, $request, $response);

		if ($response && $response->successful()) {
			$data = $response->json();

			if ($data && array_key_exists('status', $data) && $data['status'] === 'ok') {
				if ($worker->status === Worker::STATUS_INACTIVE) {
					$worker->release();
				}

				return true;
			}
		}

		$worker->last_request_at = now();
		$worker->deactivate();

		return false;
	}
}
