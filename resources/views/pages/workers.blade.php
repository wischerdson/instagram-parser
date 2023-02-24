@extends('layout')

@section('content')
	<form class="container" method="POST" action="/workers">
		<h2 class="text-2xl font-bold mb-6">Workers</h2>
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

	<form class="container" method="POST" action="/workers/iam">
		<div class="mt-2">
			<label class="form-label" for="iam">IAM</label>
			<textarea class="form-control" type="text" id="iam" name="iam"></textarea>
			<a class="text-xs text-blue-500 underline" target="_blank" href="https://darkstore.biz/products/view/instagram-mob-api-emulator-sms-last-api-ne-boatsa-cistok-zivut-v-otlezke-top-kacestvo-ocen-krepkie-100-valid">https://darkstore.biz/products/view/instagram-mob-api-emulator-sms-last-api-ne-boatsa-cistok-zivut-v-otlezke-top-kacestvo-ocen-krepkie-100-valid</a>
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
							<form action="/workers" method="POST">
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
@endsection
