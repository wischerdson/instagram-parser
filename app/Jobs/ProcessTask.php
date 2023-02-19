<?php

namespace App\Jobs;

use App\Models\Task;
use App\Services\TaskProcessors\FollowersFetchingTaskProcessor;
use App\Services\TaskProcessors\UserInfoFetchingTaskProcessor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessTask implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	public Task $task;

	public function __construct(Task $task)
	{
		$this->task = $task;
	}

	public function handle(): void
	{
		$processor = match ($this->task->type) {
			Task::TYPE_FOLLOWERS_FETCHING => new FollowersFetchingTaskProcessor($this->task),
			Task::TYPE_USER_INFO_FETCHING => new UserInfoFetchingTaskProcessor($this->task)
		};

		$processor->run();
	}
}
