<?php

namespace App\Services\TaskProcessors;

use App\Models\Follower;
use App\Models\Task;
use App\Models\TaskInputForFollowersFetching;
use App\Models\TaskResultsOfFollowersFetching;
use App\Models\User;
use App\Services\Instagram\Client;
use App\Services\Instagram\Requests\FollowersRequest;
use App\Services\Instagram\Responses\FollowersResponse;
use App\Services\TaskCreator;
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
		dump('New followers');

		$responseData = $this->response->httpResponse->json();

		$result = new TaskResultsOfFollowersFetching();
		$result->big_list = Arr::get($responseData, 'big_list');
		$result->page_size = Arr::get($responseData, 'page_size');
		$result->next_max_id = Arr::get($responseData, 'next_max_id');
		$result->has_more = Arr::get($responseData, 'has_more');
		$result->should_limit_list_of_followers = Arr::get($responseData, 'should_limit_list_of_followers');
		$result->status = Arr::get($responseData, 'status');
		$result->save();

		$this->task->result()->associate($result);
		$this->task->save();

		collect(Arr::get($responseData, 'users', []))->each(function ($user) use ($result) {
			if (Follower::where('pk', $user['pk'])->exists()) {
				return;
			}

			$follower = new Follower();
			$follower->pk = Arr::get($user, 'pk');
			$follower->username = Arr::get($user, 'username');
			$follower->full_name = Arr::get($user, 'full_name');
			$follower->is_private = Arr::get($user, 'is_private');
			$follower->is_verified = Arr::get($user, 'is_verified');
			$follower->profile_pic_url = Arr::get($user, 'profile_pic_url');

			$result->followers()->save($follower);

			if (!$follower->is_private && User::where('pk', $follower->pk)->doesntExist()) {
				TaskCreator::fetchUserInfo($follower->pk);
			}
		});

		if ($result->next_max_id) {
			TaskCreator::fetchFollowers($this->request->userPk, $result->next_max_id);
		}
	}
}
