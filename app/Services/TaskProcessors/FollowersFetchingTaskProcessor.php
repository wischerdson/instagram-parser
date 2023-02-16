<?php

namespace App\Services\TaskProcessors;

use App\Models\Follower as FollowerModel;
use App\Models\TaskRequests\FollowersFetchingRequest;
use App\Models\TaskRequests\IRequest;
use App\Models\TaskResults\FollowersFetchingResult;
use App\Services\Instagram\Client;
use App\Services\Instagram\Requests\FollowersRequest as FollowersIgRequest;
use App\Services\Instagram\Requests\Request;
use App\Services\Instagram\Responses\FollowersResponse;
use App\Services\Instagram\Responses\Response;
use Illuminate\Support\Arr;

class FollowersFetchingTaskProcessor extends TaskProcessor
{
	protected IRequest $requestData;

	protected Response $response;

	protected function createIgRequest(): FollowersIgRequest
	{
		$request = new FollowersIgRequest();
		$request->userPk = $this->requestData->user_pk;
		$request->maxId = $this->requestData->max_id;

		return $request;
	}

	protected function setIgResponse(Client $client, Request $request): void
	{
		$this->response = new FollowersResponse($client->send($request));
	}

	protected function createResult(): void
	{
		$result = new FollowersFetchingResult($this->response->httpResponse->json());
		$this->task->result()->save($result);

		collect(Arr::get($this->response->httpResponse->json(), 'users', []))->each(function ($follower) use ($result) {
			if (FollowerModel::where('pk', $follower['pk'])->exists()) {
				return;
			}

			$follower = new FollowerModel($follower);
			$result->followers()->save($follower);
		});
	}
}
