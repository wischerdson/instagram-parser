<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Parser dashboard</title>
	<script src="https://cdn.tailwindcss.com"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body class="pb-10">
	<form class="container mt-10" method="POST" action="/worker">
		<h2 class="text-2xl font-bold mb-6">Worker update or create</h2>
		<div class="row">
			<div class="col">
				<label class="form-label" for="login">Login</label>
				<input class="form-control" type="text" id="login" name="login">
			</div>
			<div class="col">
				<label class="form-label" for="password">Password</label>
				<input class="form-control" type="text" id="password" name="password">
			</div>
		</div>

		<div class="mt-2">
			<label class="form-label" for="headers">Headers</label>
			<textarea class="form-control" type="text" id="headers" name="headers"></textarea>
		</div>

		@csrf
		<button class="btn btn-primary" style="margin-top: 20px">Update or create</button>
	</form>

	<div class="container mt-10">
		<table class="table">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Login:Password</th>
					<th scope="col">Headers</th>
					<th scope="col">Status</th>
					<th scope="col"></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($workers as $worker)
					<tr>
						<th scope="row">{{ $worker->id }}</th>
						<td><span class="font-bold">{{ $worker->login }}</span>:{{ $worker->password }}</td>
						<td class="max-w-xs overflow-auto"><pre class="text-xs">{{ $worker->headers }}</pre></td>
						<td>ok</td>
						<td>
							<form action="/worker" method="POST">
								@method('DELETE')
								@csrf
								<button class="btn btn-sm btn-danger" name="id" value="{{ $worker->id }}">Delete</button>
							</form>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>



	<style>

	</style>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>
