<?php

namespace App\Services\TaskProcessors;

use App\Models\Task;
use App\Models\TaskInputForUserInfoFetching;
use App\Models\User;
use App\Services\Instagram\Client;
use App\Services\Instagram\Requests\UserInfoRequest;
use App\Services\Instagram\Responses\Response;
use App\Services\Instagram\Responses\UserInfoResponse;
use Illuminate\Support\Arr;

class UserInfoFetchingTaskProcessor extends TaskProcessor
{
	protected UserInfoRequest $request;

	protected UserInfoResponse $response;

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

		return $this->response = new UserInfoResponse($client->send($this->request));
	}

	protected function saveResult(): void
	{
		$rawUser = $this->response->httpResponse->json()['user'];

		$user = new User();
		$user->pk = Arr::get($rawUser, 'pk');
		$user->username = Arr::get($rawUser, 'username');
		$user->full_name = Arr::get($rawUser, 'full_name');
		$user->biography = Arr::get($rawUser, 'biography');
		$user->external_url = Arr::get($rawUser, 'external_url');
		$user->city_name = Arr::get($rawUser, 'city_name');
		$user->category = Arr::get($rawUser, 'category');
		$user->whatsapp_number = Arr::get($rawUser, 'whatsapp_number');
		$user->contact_phone_number = Arr::get($rawUser, 'contact_phone_number');
		$user->public_phone_number = Arr::get($rawUser, 'public_phone_number');
		$user->public_phone_country_code = Arr::get($rawUser, 'public_phone_country_code');
		$user->public_email = Arr::get($rawUser, 'public_email');
		$user->address_street = Arr::get($rawUser, 'address_street');
		$user->is_business = Arr::get($rawUser, 'is_business');
		$user->save();

		dump('New user: '.$user->username);

		$this->task->result()->associate($user);
	}
}
