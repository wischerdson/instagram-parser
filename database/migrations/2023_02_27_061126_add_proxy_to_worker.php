<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::table('workers', function (Blueprint $table) {
			$table->string('proxy')->nullable()->after('password');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		DB::statement('ALTER TABLE workers DROP COLUMN `proxy`');
	}
};
