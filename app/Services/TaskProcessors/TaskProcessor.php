<?php

namespace App\Services\TaskProcessors;

use App\Models\RequestLog;
use App\Models\Task;
use App\Models\Worker;
use App\Integrations\Instagram\Client;
use App\Integrations\Instagram\Headers;
use App\Integrations\Instagram\Request;
use App\Integrations\Instagram\Response;
use App\Services\TasksDispatcher;

abstract class TaskProcessor
{
	protected Task $task;

	protected Worker $worker;

	public function __construct(Task $task)
	{
		$this->task = $task;
		$this->worker = $task->worker;
	}

	public function run(): bool
	{
		$request = $this->getRequest();
		$headers = Headers::parse($this->worker->headers);
		$request->authorize($headers);

		$response = $this->createResponse(new Client());

		if ($response) {
			$this->logRequest($request, $response);

			if ($response->isSomethingWrong()) {
				$this->task->setFailedStatus();
				$this->task->save();

				$this->worker->deactivate();

				return false;
			}

			$this->saveResult($response);
		}

		$this->task->setProcessedStatus();
		$this->task->save();
		$this->worker->release();

		TasksDispatcher::assignWork();

		return true;
	}

	protected function createResponse(Client $client): ?Response
	{
		return $client->send($this->getRequest());
	}

	private function logRequest(Request $request, Response $response): void
	{
		if (!$response->httpResponse) {
			return;
		}

		$log = new RequestLog();
		$log->worker_id = $this->worker->id;
		$log->url = $request->getUrl();
		$log->method = $request->getMethod();
		$log->request_query = $request->getQuery();
		$log->body = $request->getBody();
		$log->headers = $request->getHeaders()->toString();
		$log->response_headers = $response->httpResponse->headers();
		$log->response_body = $response->httpResponse->body();
		$log->http_code = $response->httpResponse->status();

		$this->task->logs()->save($log);
	}

	abstract protected function getRequest(): Request;

	abstract protected function saveResult(Response $response): void;
}
