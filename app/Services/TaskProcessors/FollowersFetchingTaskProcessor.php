<?php

namespace App\Services\TaskProcessors;

use App\Integrations\Instagram\Dto\Follower as DtoFollower;
use App\Models\Follower;
use App\Models\Task;
use App\Models\TaskInputForFollowersFetching;
use App\Models\TaskResultsOfFollowersFetching;
use App\Models\User;
use App\Integrations\Instagram\Requests\FollowersRequest;
use App\Integrations\Instagram\Response;
use App\Services\TaskCreator;

class FollowersFetchingTaskProcessor extends TaskProcessor
{
	protected FollowersRequest $request;

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

	protected function saveResult(Response $response): void
	{
		/** @var \App\Integrations\Instagram\Dto\FollowersResponse $dto */
		$dto = $response->dto();

		$result = new TaskResultsOfFollowersFetching($dto->toArray());
		$result->save();

		$this->task->result()->associate($result);
		$this->task->save();

		$dto->followers->each(function (DtoFollower $dtoFollower) use ($result) {
			if (Follower::where('pk', $dtoFollower->pk)->exists()) {
				return;
			}

			$follower = new Follower($dtoFollower->toArray());
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
