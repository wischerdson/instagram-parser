<?php

namespace App\Services\TaskProcessors;

use App\Models\RequestLog;
use App\Models\Task;
use App\Models\TaskRequests\IRequest;
use App\Models\Worker;
use App\Services\Instagram\Client;
use App\Services\Instagram\Headers;
use App\Services\Instagram\Requests\Request;
use App\Services\Instagram\Responses\Response;

abstract class TaskProcessor
{
	protected Task $task;

	protected Worker $worker;

	protected IRequest $requestData;

	public function __construct(Task $task)
	{
		$this->task = $task;
		$this->worker = $task->worker;
		$this->requestData = $task->request;
	}

	public function run(): bool
	{
		$request = $this->createIgRequest();
		$headers = Headers::parse($this->worker->headers);
		$request->authorize($headers);

		$response = $this->createIgResponse(new Client(), $request);

		$this->logRequest($request, $response);

		if ($response->isSomethingWrong()) {
			$this->task->setFailedStatus();
			$this->task->save();

			$this->worker->deactivate();

			return false;
		}

		$this->createResult($response);

		return true;
	}

	private function logRequest(Request $request, Response $response): void
	{
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

	abstract protected function createIgRequest(): Request;

	abstract protected function createIgResponse(Client $client, Request $request): Response;

	abstract protected function createResult(Response $response): void;
}
