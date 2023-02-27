<?php

use App\Models\Worker;

?>

@extends('layout')

@section('content')
	<div class="container relative">
		<form class="absolute top-0 right-4" action="/workers/{{ $worker->id }}" method="POST">
			@method('DELETE')
			@csrf
			<button class="btn btn-sm btn-danger">Delete</button>
		</form>
		<form method="POST" action="/workers/{{ $worker->id }}">
			<h2 class="text-2xl font-bold mb-4">Update</h2>
			<div class="row">
				<div class="col">
					<label class="form-label" for="login">Login</label>
					<input class="form-control" type="text" id="login" name="login" value="{{ $worker->login }}">
				</div>
				<div class="col">
					<label class="form-label" for="password">Password</label>
					<input class="form-control" type="text" id="password" name="password" value="{{ $worker->password }}">
				</div>
				<div class="col">
					<label class="form-label" for="proxy">Proxy</label>
					<input class="form-control" type="text" id="proxy" name="proxy" value="{{ $worker->proxy }}">
				</div>
				<div class="col">
					<label class="form-label" for="proxy">Status</label>
					<select class="form-select" id="status" name="status">
						<option value="{{ Worker::STATUS_READY_TO_WORK }}" @selected($worker->status === Worker::STATUS_READY_TO_WORK)>Ready do work</option>
						<option value="{{ Worker::STATUS_BUSY }}" @selected($worker->status === Worker::STATUS_BUSY)>Buzy</option>
						<option value="{{ Worker::STATUS_INACTIVE }}" @selected($worker->status === Worker::STATUS_INACTIVE)>Inactive</option>
					</select>
				</div>
			</div>

			<div class="mt-2">
				<label class="form-label" for="headers">Headers</label>
				<textarea class="form-control" type="text" id="headers" name="headers" rows="10">{{ $worker->headers }}</textarea>
			</div>

			@method('PUT')
			@csrf
			<button class="btn btn-primary mt-3">Save</button>
		</form>
		<div class="mt-10">
			@if ($worker->lastRequestLog)
				<h2 class="text-2xl font-bold mb-4">Last request log</h2>
				<table class="table">
					<tbody>
						<tr>
							<th scope="row">URL</th>
							<td scope="row"><pre class="text-sm">{{ $worker->lastRequestLog->url }}</pre></td>
						</tr>
						<tr>
							<th scope="row">Query</th>
							<td scope="row"><pre class="text-sm">{{ $worker->lastRequestLog->query }}</pre></td>
						</tr>
						<tr>
							<th scope="row">Body</th>
							<td scope="row"><pre class="text-sm">{{ $worker->lastRequestLog->body ?: '-' }}</pre></td>
						</tr>
						<tr>
							<th scope="row">Headers</th>
							<td scope="row"><pre class="text-sm">{{ $worker->lastRequestLog->headers }}</pre></td>
						</tr>
						<tr>
							<th scope="row">Response headers</th>
							<td scope="row"><pre class="text-sm"><?php dump($worker->lastRequestLog->response_headers) ?></pre></td>
						</tr>
						<tr>
							<th scope="row">Response body</th>
							<td scope="row"><pre class="text-sm"><?php dump($worker->lastRequestLog->response_body) ?></pre></td>
						</tr>
						<tr>
							<th scope="row">HTTP code</th>
							<td scope="row"><pre class="text-sm">{{ $worker->lastRequestLog->http_code }}</pre></td>
						</tr>
					</tbody>
				</table>
			@endif
		</div>
	</div>
@endsection
