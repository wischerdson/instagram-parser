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

		</div>
	</div>
@endsection
