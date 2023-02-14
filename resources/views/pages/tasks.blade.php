@extends('layout')

@section('content')
	<div class="container">
		<h2 class="text-2xl font-bold">Collecting followers task</h2>
		<form class="mt-6" method="POST" action="/tasks">
			@csrf
			<div class="input-group max-w-sm">
				<div class="input-group-text">User PK</div>
				<input class="form-control" type="text" name="pk">
				<button class="btn btn-primary">Add</button>
			</div>
		</form>
	</div>
@endsection
