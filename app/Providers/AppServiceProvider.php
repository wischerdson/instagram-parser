<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{

	}

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		JsonResource::withoutWrapping();

		Relation::morphMap([
			'followers_fetching_request' => \App\Models\TaskRequests\FollowersFetchingRequest::class,
			'followers_fetching_result' => \App\Models\TaskResults\FollowersFetchingResult::class,
			'user_info_fetching_request' => \App\Models\TaskRequests\UserInfoFetchingRequest::class,
			'user_info_fetching_result' => \App\Models\TaskResults\UserInfoFetchingResult::class,
		]);
	}
}
