<?php

namespace App\Http\Controllers;

use App\Services\TaskCreator;
use App\Services\TasksDispatcher;
use Illuminate\Http\Request;

class TaskController extends Controller
{
	public function index()
	{
		return view('pages.tasks', []);
	}

	public function create(Request $request)
	{
		TaskCreator::fetchFollowers($request->pk);
		TasksDispatcher::assignWork();

		return redirect()->back();
	}
}
