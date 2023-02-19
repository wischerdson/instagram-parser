<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use App\Services\TasksDispatcher;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
	public function index()
	{
		$workers = Worker::all();

		return view('pages.workers', ['workers' => $workers]);
	}

	public function updateOrCreate(Request $request)
	{
		$fields = $request->collect()->filter();

		Worker::updateOrCreate(
			['login' => $fields->get('login')],
			$fields->except('_token')->toArray()
		);

		TasksDispatcher::assignWork();

		return redirect()->back();
	}

	public function delete(Request $request)
	{
		Worker::destroy($request->id);

		return redirect()->back();
	}
}
