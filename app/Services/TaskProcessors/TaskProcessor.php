<?php

namespace App\Services\TaskProcessors;

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

	public function run(): void
	{
		$request = $this->createIgRequest();
		$headers = Headers::parse($this->worker->headers);
		$request->authorize($headers);

		$response = $this->createIgResponse(new Client(), $request);
	}

	abstract protected function createIgRequest(): Request;

	abstract protected function createIgResponse(Client $client, Request $request): Response;
}
