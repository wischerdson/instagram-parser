<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('workers', function (Blueprint $table) {
			$table->id();
			$table->string('login')->unique();
			$table->string('password');
			$table->text('headers')->nullable();
			$table->enum('status', ['ready_to_work', 'busy', 'inactive']);
			$table->timestamp('last_request_at')->nullable();
			$table->timestamp('sleeps_until')->nullable();
			$table->timestamp('created_at')->useCurrent();
		});

		Schema::create('tasks', function (Blueprint $table) {
			$table->id();
			$table->string('type');
			$table->string('input_data_type');
			$table->string('input_data_id');
			$table->string('result_type')->nullable();
			$table->bigInteger('result_id')->unsigned()->nullable();
			$table->enum('status', ['unprocessed', 'in_process', 'processed', 'failed']);
			$table->foreignId('worker_id')->nullable()->constrained('workers')->nullOnDelete();
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('processed_at')->nullable();
		});

		Schema::create('task_input_for_followers_fetching', function (Blueprint $table) {
			$table->id();
			$table->string('max_id')->nullable();
			$table->string('user_pk');
		});

		Schema::create('task_results_of_followers_fetching', function (Blueprint $table) {
			$table->id();
			$table->boolean('big_list')->nullable();
			$table->smallInteger('page_size')->unsigned()->nullable();
			$table->string('next_max_id')->nullable();
			$table->boolean('has_more')->nullable();
			$table->boolean('should_limit_list_of_followers')->nullable();
			$table->string('status');
			$table->timestamp('created_at')->useCurrent();
		});

		Schema::create('task_input_for_user_info_fetching', function (Blueprint $table) {
			$table->id();
			$table->string('user_pk');
		});

		Schema::create('followers', function (Blueprint $table) {
			$table->id();
			$table->foreignId('result_id')->constrained('task_results_of_followers_fetching')->cascadeOnDelete();
			$table->string('pk')->unique();
			$table->string('username')->unique();
			$table->string('full_name')->nullable();
			$table->boolean('is_private');
			$table->boolean('is_verified');
			$table->string('profile_pic_url')->nullable();
		});

		Schema::create('users', function (Blueprint $table) {
			$table->id();
			$table->string('pk')->unique();
			$table->string('username')->unique();
			$table->string('full_name')->nullable();
			$table->text('biography')->nullable();
			$table->string('external_url')->nullable();
			$table->string('city_name')->nullable();
			$table->string('category')->nullable();
			$table->string('whatsapp_number')->nullable();
			$table->string('contact_phone_number')->nullable();
			$table->string('public_phone_number')->nullable();
			$table->string('public_phone_country_code')->nullable();
			$table->string('public_email')->nullable();
			$table->string('address_street')->nullable();
			$table->boolean('is_business')->nullable();
			$table->timestamp('created_at')->useCurrent();
		});

		Schema::create('requests_logs', function (Blueprint $table) {
			$table->id();
			$table->foreignId('worker_id')->nullable()->constrained('workers')->nullOnDelete();
			$table->foreignId('task_id')->constrained('tasks')->cascadeOnDelete();
			$table->string('url');
			$table->string('method', 10);
			$table->text('query')->nullable();
			$table->text('body')->nullable();
			$table->text('headers')->nullable();
			$table->text('response_headers');
			$table->text('response_body');
			$table->smallInteger('http_code')->unsigned();
			$table->timestamp('created_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('requests_logs');
		Schema::dropIfExists('users');
		Schema::dropIfExists('followers');
		Schema::dropIfExists('task_input_for_user_info_fetching');
		Schema::dropIfExists('task_results_of_followers_fetching');
		Schema::dropIfExists('task_input_for_followers_fetching');
		Schema::dropIfExists('tasks');
		Schema::dropIfExists('workers');
	}
};
