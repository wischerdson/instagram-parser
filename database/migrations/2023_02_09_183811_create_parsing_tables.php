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
			$table->text('headers');
			$table->string('status')->default('waiting');
			$table->timestamp('sleeps_until')->nullable();
			$table->timestamp('created_at')->useCurrent();
		});

		Schema::create('tasks', function (Blueprint $table) {
			$table->id();
			$table->bigInteger('taskable_id')->unsigned();
			$table->string('taskable_type');
			$table->enum('status', ['unprocessed', 'in_process', 'processed', 'failed']);
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('processed_at')->nullable();
		});

		Schema::create('fetch_followers_tasks', function (Blueprint $table) {
			$table->id();
			$table->string('pk');
			$table->string('next_max_id');
		});

		Schema::create('fetched_followers_task_results', function (Blueprint $table) {
			$table->id();
			$table->foreignId('task_id')->constrained('tasks')->cascadeOnDelete();
			$table->string('pk');
			$table->string('username');
			$table->string('full_name');
			$table->boolean('is_private');
			$table->boolean('is_verified');
			$table->string('profile_pic_url');
		});

		Schema::create('fetch_user_info_tasks', function (Blueprint $table) {
			$table->id();
			$table->string('pk');
		});

		Schema::create('fetched_user_info_results', function (Blueprint $table) {
			$table->id();
			$table->foreignId('task_id')->constrained('tasks')->cascadeOnDelete();
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

		Schema::create('requests_details', function (Blueprint $table) {
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
			$table->text('response_status');
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
		Schema::dropIfExists('requests_details');
		Schema::dropIfExists('fetched_user_info_results');
		Schema::dropIfExists('fetch_user_info_tasks');
		Schema::dropIfExists('fetched_followers_task_results');
		Schema::dropIfExists('fetch_followers_tasks');
		Schema::dropIfExists('tasks');
		Schema::dropIfExists('workers');
	}
};
