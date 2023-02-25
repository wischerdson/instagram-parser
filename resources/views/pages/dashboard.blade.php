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
		<table class="table mt-10">
			<thead>
				<th>Аккаунт</th>
				<th>Выполнил задач сегодня</th>
				<th>Выполнил задач всего</th>
				<th>Дата последнего запроса</th>
			</thead>
			<tbody>
				@foreach ($accounts as $account)
					<tr>
						<td class="whitespace-nowrap">
							@if ($account->status === \App\Models\Worker::STATUS_INACTIVE)
								<div class="inline-block w-2 h-2 rounded-full bg-red-500"></div>
							@else
								<div class="inline-block w-2 h-2 rounded-full bg-green-500"></div>
							@endif
							{{ $account->login }}
						</td>
						<td>{{ $account->today_tasks_count }}</td>
						<td>{{ $account->tasks_count }}</td>
						<td>{{ $account->lastTask->processed_at }}</td>
						@if ($account->status === \App\Models\Worker::STATUS_INACTIVE)
							<td><a class="btn btn-primary btn-sm" href="/worker-healthcheck/{{ $account->id }}">Healthcheck</a></td>
						@endif
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@endsection
