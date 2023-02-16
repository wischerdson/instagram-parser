<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('followers_fetching_results', function (Blueprint $table) {
			$table->id();
			$table->boolean('big_list')->nullable();
			$table->smallInteger('page_size')->unsigned()->nullable();
			$table->string('next_max_id')->nullable();
			$table->boolean('has_more')->nullable();
			$table->boolean('should_limit_list_of_followers')->nullable();
			$table->string('status');
			$table->timestamp('created_at')->useCurrent();
		});

		Schema::create('followers', function (Blueprint $table) {
			$table->id();
			$table->foreignId('followers_fetching_result_id')->constrained('followers_fetching_results')->cascadeOnDelete();
			$table->string('pk')->unique();
			$table->string('username')->unique();
			$table->string('full_name')->nullable();
			$table->boolean('is_private');
			$table->boolean('is_verified');
			$table->string('profile_pic_url')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('followers');
		Schema::dropIfExists('followers_fetching_results');
	}
};
