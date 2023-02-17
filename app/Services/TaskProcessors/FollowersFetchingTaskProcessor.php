<?php

namespace App\Services\TaskProcessors;

use App\Models\Follower;
use App\Models\Task;
use App\Models\TaskInputForFollowersFetching;
use App\Models\TaskResults\FollowersFetchingResult;
use App\Services\Instagram\Client;
use App\Services\Instagram\Requests\FollowersRequest;
use App\Services\Instagram\Responses\FollowersResponse;
use Illuminate\Support\Arr;

class FollowersFetchingTaskProcessor extends TaskProcessor
{
	protected FollowersRequest $request;

	protected FollowersResponse $response;

	protected TaskInputForFollowersFetching $inputData;

	public function __construct(Task $task)
	{
		parent::__construct($task);

		$this->inputData = $task->inputData;

		$this->request = new FollowersRequest();
		$this->request->userPk = $this->inputData->user_pk;
		$this->request->maxId = $this->inputData->max_id;
	}

	protected function getRequest(): FollowersRequest
	{
		return $this->request;
	}

	protected function createResponse(Client $client): FollowersResponse
	{
		return $this->response = new FollowersResponse($client->send($this->request));
	}

	protected function saveResult(): void
	{
		$result = new FollowersFetchingResult($this->response->httpResponse->json());
		$this->task->result()->save($result);

		collect(Arr::get($this->response->httpResponse->json(), 'users', []))->each(function ($follower) use ($result) {
			if (Follower::where('pk', $follower['pk'])->exists()) {
				return;
			}

			$follower = new Follower($follower);
			$result->followers()->save($follower);
		});
	}
}
