<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Database\Eloquent\Builder;

class DashboardController extends Controller
{
	public function index()
	{
		return view('pages.dashboard', [
			'users_total' => User::count(),
			'users_total_today' => User::where('created_at', '>=', today())->count(),
			'tasks_total' => Task::count(),
			'tasks_completed' => Task::where('status', Task::STATUS_PROCESSED)->count(),
			'tasks_completed_today' => Task::where('status', Task::STATUS_PROCESSED)->where('processed_at', '>', today())->count(),
			'active_accounts' => Worker::whereNot('status', Worker::STATUS_INACTIVE)->count(),
			'all_accounts' => Worker::count(),
			'failed_tasks' => Task::where('status', Task::STATUS_FAILED)->count(),
			'accounts' => Worker::with('lastTask')->withCount([
				'tasks as tasks_count' => function (Builder $query) {
					$query->where('status', Task::STATUS_PROCESSED);
				},
				'tasks as today_tasks_count' => function (Builder $query) {
					$query->where('processed_at', '>=', today());
				}
			])->get()
		]);
	}
}
