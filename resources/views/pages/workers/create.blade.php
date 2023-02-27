@extends('layout')

@section('content')
	<div class="container">
		<form method="POST" action="/workers/iam">
			<h2 class="text-2xl font-bold mb-4">Create via IAM</h2>
			<div>
				<label class="form-label" for="iam">IAM</label>
				<textarea class="form-control" type="text" id="iam" name="iam" rows="10"></textarea>
				<a class="text-xs text-blue-500 underline" target="_blank" href="https://darkstore.biz/products/view/instagram-mob-api-emulator-sms-last-api-ne-boatsa-cistok-zivut-v-otlezke-top-kacestvo-ocen-krepkie-100-valid">https://darkstore.biz/products/view/instagram-mob-api-emulator-sms-last-api-ne-boatsa-cistok-zivut-v-otlezke-top-kacestvo-ocen-krepkie-100-valid</a>
			</div>

			@csrf
			<button class="btn btn-primary" style="margin-top: 20px">Create</button>
		</form>

		<form class="mt-10" method="POST" action="/workers">
			<h2 class="text-2xl font-bold mb-4">Create with headers</h2>
			<div class="row">
				<div class="col">
					<label class="form-label" for="login">Login</label>
					<input class="form-control" type="text" id="login" name="login">
				</div>
				<div class="col">
					<label class="form-label" for="password">Password</label>
					<input class="form-control" type="text" id="password" name="password">
				</div>
				<div class="col">
					<label class="form-label" for="proxy">Proxy</label>
					<input class="form-control" type="text" id="proxy" name="proxy">
				</div>
			</div>

			<div class="mt-2">
				<label class="form-label" for="headers">Headers</label>
				<textarea class="form-control" type="text" id="headers" name="headers" rows="10"></textarea>
			</div>

			@csrf
			<button class="btn btn-primary" style="margin-top: 20px">Create</button>
		</form>
	</div>
@endsection
