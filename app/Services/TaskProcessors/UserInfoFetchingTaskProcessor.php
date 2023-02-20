<?php

namespace App\Services\TaskProcessors;

use App\Models\Task;
use App\Models\TaskInputForUserInfoFetching;
use App\Models\User;
use App\Integrations\Instagram\Client;
use App\Integrations\Instagram\Requests\UserInfoRequest;
use App\Integrations\Instagram\Response;

class UserInfoFetchingTaskProcessor extends TaskProcessor
{
	protected UserInfoRequest $request;

	protected TaskInputForUserInfoFetching $inputData;

	public function __construct(Task $task)
	{
		parent::__construct($task);

		$this->inputData = $task->inputData;

		$this->request = new UserInfoRequest();
		$this->request->userPk = $this->inputData->user_pk;
	}

	protected function getRequest(): UserInfoRequest
	{
		return $this->request;
	}

	protected function createResponse(Client $client): ?Response
	{
		if (User::where('pk', $this->request->userPk)->exists()) {
			return null;
		}

		return parent::createResponse($client);
	}

	protected function saveResult(Response $response): void
	{
		/** @var \App\Integrations\Instagram\Dto\UserInfoResponse */
		$dtoResponse = $response->dto();
		$dtoUser = $dtoResponse->user;

		$user = new User($dtoUser->toArray());
		$user->save();

		dump('New user: '.$user->username);

		$this->task->result()->associate($user);
	}
}
