<?php

namespace App\Http\Controllers;

use App\Models\Task\FetchFollowersTask;
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

		if (FetchFollowersTask::where('pk', $pk)->exists()) {
			return redirect()->back();
		}

		$task = FetchFollowersTask::firstOrUpdate(['pk' => $pk], ['pk' => $pk]);
	}
}
