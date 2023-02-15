<?php

namespace App\Services\TaskProcessors;

use App\Models\TaskRequests\UserInfoFetchingRequest;
use App\Services\Instagram\Client;
use App\Services\Instagram\Requests\Request;
use App\Services\Instagram\Requests\UserInfoRequest;
use App\Services\Instagram\Responses\Response;
use App\Services\Instagram\Responses\UserInfoResponse;

class UserInfoFetchingTaskProcessor extends TaskProcessor
{
	protected UserInfoFetchingRequest $requestData;

	protected function createIgRequest(): UserInfoRequest
	{
		$request = new UserInfoRequest();
		$request->userPk = $this->requestData->user_pk;

		return $request;
	}

	protected function createIgResponse(Client $client, Request $request): Response
	{
		return new UserInfoResponse($client->send($request));
	}
}
