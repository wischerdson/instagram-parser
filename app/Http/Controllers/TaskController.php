<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskRequests\FollowersFetchingRequest;
use Illuminate\Http\Request;

class TaskController extends Controller
{
	public function index()
	{
		return view('pages.tasks', []);
	}

	public function create(Request $request)
	{
		$pk = $request->pk;

		$igRequest = new FollowersFetchingRequest();
		$igRequest->user_pk = $pk;
		$igRequest->save();

		$task = new Task();
		$task->setFollowerFetchingType();

		$igRequest->task()->save($task);

		return redirect()->back();
	}
}
