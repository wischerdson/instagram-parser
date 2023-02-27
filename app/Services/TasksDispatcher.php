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

			$worker->loadWithTask();

			$task->worker()->associate($worker);
			$task->setInProcessStatus();
			$task->save();

			$delay = random_int(10, 60);
			dump('Find task #'.$task->id.' for worker '.$worker->login.' with delay in '.$delay.'s');

			ProcessTask::dispatch($task)->delay(now()->addSeconds($delay));
		}
	}

	private function findTasks(int $count): Collection
	{
		return Task::unprocessed()->with('inputData')->inRandomOrder()->limit($count)->get();
	}

	private function findFreeWorkers(): Collection
	{
		return Worker::free()->get();
	}
}
