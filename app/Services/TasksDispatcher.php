<?php

namespace App\Services;

use App\Jobs\ProcessTask;
use App\Models\Task;
use App\Models\Worker;
use Illuminate\Database\Eloquent\Collection;

class TasksDispatcher
{
	public static function assignWork(): void
	{
		$instance = new self();

		$freeWorkers = $instance->findFreeWorkers();
		$tasks = $instance->findTasks($freeWorkers->count());

		foreach ($tasks as $idx => $task) {
			$worker = $freeWorkers[$idx];

			$task->worker()->associate($worker);
			$task->setInProcessStatus();
			$task->save();

			ProcessTask::dispatch($task);
		}
	}

	private function findTasks(int $count): Collection
	{
		return Task::unprocessed()->with('request')->inRandomOrder()->limit($count)->get();
	}

	private function findFreeWorkers(): Collection
	{
		return Worker::free()->get();
	}
}
