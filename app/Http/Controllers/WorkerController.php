<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use App\Services\TasksDispatcher;
use App\Services\WorkerHealthcheck;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
	public function create()
	{
		return view('pages.workers.create');
	}

	public function edit(int $workerId)
	{
		$worker = Worker::findOrFail($workerId);
		$worker->load('lastRequestLog');

		return view('pages.workers.edit', ['worker' => $worker]);
	}

	public function store(Request $request)
	{
		$fields = $request->collect()->filter();

		Worker::updateOrCreate(
			['login' => $fields->get('login')],
			$fields->except('_token')->toArray()
		);

		return redirect()->to('/workers');
	}

	public function update(int $id, Request $request)
	{
		$fields = $request->collect()->filter();
		$worker = Worker::findOrFail($id);
		$worker->fill($fields->all());
		$worker->save();

		return redirect()->back();
	}

	public function storeViaIam(Request $request)
	{
		$iam = $request->iam;

		$rows = explode('||', $iam);

		foreach ($rows as $row) {
			if (!$row) {
				continue;
			}

			[$credentials, $useragent, $techData, $cookie] = explode('|', $row);
			[$login, $password] = explode(':', $credentials);

			$headers = [
				"User-Agent: {$useragent}",
				"Cookie: {$cookie}"
			];

			Worker::updateOrCreate(
				['login' => trim($login)],
				[
					'password' => trim($password),
					'headers' => implode("\n", $headers)
				]
			);
		}

		return redirect()->to('/workers');
	}

	public function delete(int $id)
	{
		Worker::destroy($id);

		return redirect()->back();
	}

	public function healthcheck(int $id)
	{
		$result = WorkerHealthcheck::check(Worker::find($id));

		return redirect()->back()->with('healthcheck', $result);
	}

	public function load()
	{
		TasksDispatcher::assignWork();

		return redirect()->back();
	}
}
