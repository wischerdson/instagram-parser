<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskInputForFollowersFetching;
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

		$inputData = new TaskInputForFollowersFetching();
		$inputData->user_pk = $pk;
		$inputData->save();

		$task = new Task();
		$task->setFollowerFetchingType();

		$inputData->task()->save($task);

		return redirect()->back();
	}
}
