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
		Schema::create('crawled_users', function (Blueprint $table) {
			$table->id();
			$table->string('ig_pk')->unique();
			$table->string('ig_username')->unique();
			$table->string('ig_full_name')->nullable();
			$table->string('ig_biography')->nullable();
			$table->string('ig_category')->nullable();
			$table->string('city')->nullable();
			$table->string('email')->nullable();
			$table->string('phone')->unique()->nullable();
			$table->string('phone_country_code')->nullable();
			$table->string('phone_national_number')->nullable();
			$table->string('phone_region_code')->nullable();
			$table->boolean('is_business')->default(false);
			$table->timestamp('created_at')->useCurrent();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('crawled_users');
	}
};
