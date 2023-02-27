<?php

namespace App\Services\TaskProcessors;

use App\Models\Task;
use App\Models\Worker;
use App\Integrations\Instagram\Headers;
use App\Integrations\Instagram\Proxy;
use App\Integrations\Instagram\Request;
use App\Integrations\Instagram\Response;
use App\Services\RequestLogger;
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

		if ($this->worker->proxy) {
			$request->useProxy(new Proxy($this->worker->proxy));
		}

		if ($this->beforeRequestSend()) {
			$response = $request->send();

			RequestLogger::log($this->worker, $request, $response->httpResponse, $this->task);

			if ($response->isSomethingWrong()) {
				if (!($json = $response->httpResponse->json()) || $json['message'] !== 'Target user not found') {
					$this->task->setFailedStatus();
					$this->task->save();

					$this->worker->deactivate();

					return false;
				}
			}

			$this->worker->last_request_at = now();
			$this->saveResult($response);
		}

		$this->task->setProcessedStatus();
		$this->task->processed_at = now();
		$this->task->save();

		$this->worker->release();

		TasksDispatcher::assignWork();

		return true;
	}

	protected function beforeRequestSend(): bool
	{
		return true;
	}

	abstract protected function getRequest(): Request;

	abstract protected function saveResult(Response $response): void;
}
