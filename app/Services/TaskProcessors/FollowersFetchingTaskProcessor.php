<?php

namespace App\Services\TaskProcessors;

use App\Models\TaskRequests\FollowersFetchingRequest;
use App\Services\Instagram\Client;
use App\Services\Instagram\Requests\FollowersRequest as FollowersIgRequest;
use App\Services\Instagram\Requests\Request;
use App\Services\Instagram\Responses\FollowersResponse;
use App\Services\Instagram\Responses\Response;

class FollowersFetchingTaskProcessor extends TaskProcessor
{
	protected FollowersFetchingRequest $requestData;

	protected function createIgRequest(): FollowersIgRequest
	{
		$request = new FollowersIgRequest();
		$request->userPk = $this->requestData->user_pk;
		$request->maxId = $this->requestData->max_id;

		return $request;
	}

	protected function createIgResponse(Client $client, Request $request): Response
	{
		return new FollowersResponse($client->send($request));
	}

	protected function createResult(Response $response): void
	{

	}
}
