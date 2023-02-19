<?php

namespace App\Services;

use App\Models\Task;
use App\Models\TaskInputForFollowersFetching;
use App\Models\TaskInputForUserInfoFetching;

class TaskCreator
{
	public static function fetchFollowers(string $userPk, string $maxId = null)
	{
		$inputData = new TaskInputForFollowersFetching();
		$inputData->user_pk = $userPk;
		$inputData->max_id = $maxId;
		$inputData->save();

		$task = new Task();
		$task->setFollowerFetchingType();

		$inputData->task()->save($task);
	}

	public static function fetchUserInfo(string $userPk)
	{
		$inputData = new TaskInputForUserInfoFetching();
		$inputData->user_pk = $userPk;
		$inputData->save();

		$task = new Task();
		$task->setUserInfoFetchingType();

		$inputData->task()->save($task);
	}
}
