<?php

namespace App\Services;

use App\Integrations\Instagram\Request;
use App\Models\RequestLog;
use App\Models\Task;
use App\Models\Worker;
use Illuminate\Http\Client\Response;

class RequestLogger
{
	public static function log(Worker $worker, Request $request, ?Response $response, ?Task $task = null): void
	{
		if ($response === null) {
			return;
		}

		$log = new RequestLog();
		$log->url = $request->getUrl();
		$log->method = $request->getMethod();
		$log->request_query = $request->getQuery();
		$log->body = $request->getBody();
		$log->headers = $request->getHeaders()->toString();
		$log->response_headers = $response->headers();
		$log->response_body = $response->body();
		$log->http_code = $response->status();

		$worker->requestLogs()->save($log);

		if ($task) {
			$task->logs()->associate($log);
		}
	}
}
