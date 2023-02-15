<?php

namespace App\Jobs;

use App\Models\Task;
use App\Services\TaskProcessor;
use App\Services\TaskProcessors\FollowersFetchingTaskProcessor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessTask implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	public function __construct(public Task $task)
	{

	}

	public function handle(): void
	{
		$processor = new FollowersFetchingTaskProcessor($this->task);
		$processor->run();
	}
}
