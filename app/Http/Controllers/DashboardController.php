<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
	public function index()
	{
		$workers = Worker::all();

		return view('dashboard', ['workers' => $workers]);
	}

	public function worker(Request $request)
	{
		$fields = $request->collect()->filter();

		Worker::updateOrCreate(['login' => $fields->login], $fields->except('_token'));

		return redirect()->back();
	}

	public function deleteWorker(Request $request)
	{
		Worker::destroy($request->id);

		return redirect()->back();
	}
}
