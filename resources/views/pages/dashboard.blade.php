@extends('layout')

@section('content')
	<div class="container">
		<h2 class="text-2xl font-bold">Dashboard</h2>
		<table class="table max-w-lg mt-10">
			<tbody>
				<tr>
					<td>Собрано пользователей</td>
					<td>{{ $users_total }}</td>
				</tr>
				<tr>
					<td>Собрано пользователей сегодня</td>
					<td>{{ $users_total_today }}</td>
				</tr>
				<tr>
					<td>Всего задач</td>
					<td>{{ $tasks_total }}</td>
				</tr>
				<tr>
					<td>Выполнено задач</td>
					<td>{{ $tasks_completed }}</td>
				</tr>
				<tr>
					<td>Выполнено задач сегодня</td>
					<td>{{ $tasks_completed_today }}</td>
				</tr>
				<tr>
					<td>Активных аккаунтов</td>
					<td>{{ $active_accounts }}/{{ $all_accounts }}</td>
				</tr>
				<tr>
					<td>Задачи, завершенные с ошибкой</td>
					<td>{{ $failed_tasks }}</td>
				</tr>
			</tbody>
		</table>
		<div class="mt-10 mb-2 flex space-x-4">
			<a class="btn btn-primary" href="/workers/create">Create new worker(s)</a>
			<a class="btn btn-light" href="/workers/load">Assign works</a>
		</div>
		<table class="table">
			<thead>
				<th>#</th>
				<th>Аккаунт</th>
				<th>Выполнил задач сегодня</th>
				<th>Выполнил задач всего</th>
				<th>Дата последнего запроса</th>
				<th></th>
			</thead>
			<tbody>
				@foreach ($accounts as $worker)
					<tr>
						<td>{{ $worker->id }}</td>
						<td class="whitespace-nowrap">
							@if ($worker->status === \App\Models\Worker::STATUS_INACTIVE)
								<div class="inline-block w-2 h-2 rounded-full bg-red-500"></div>
							@elseif ($worker->status === \App\Models\Worker::STATUS_PAUSE)
								<div class="inline-block w-2 h-2 rounded-full bg-amber-500"></div>
							@else
								<div class="inline-block w-2 h-2 rounded-full bg-green-500"></div>
							@endif
							<span><b>{{ $worker->login }}</b>:{{ $worker->password }}</span>
						</td>
						<td>{{ $worker->today_tasks_count }}</td>
						<td>{{ $worker->tasks_count }}</td>
						<td>
							@if ($worker->lastTask)
								{{ $worker->lastTask->processed_at }}
							@endif
						</td>
						<td>
							<a class="btn btn-primary btn-sm" href="/workers/{{ $worker->id }}">Details</a>
							@if ($worker->status === \App\Models\Worker::STATUS_INACTIVE)
								<a class="btn btn-info btn-sm" href="/worker-healthcheck/{{ $worker->id }}">Healthcheck</a>
							@endif
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@endsection
