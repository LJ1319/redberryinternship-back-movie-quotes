<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::table('quotes', function (Blueprint $table) {
			$table->after(
				'id',
				fn () => $table->foreignId('user_id')->constrained()->cascadeOnDelete()
			);
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('quotes', function (Blueprint $table) {
			$table->dropForeign('quotes_user_id_foreign');
		});
	}
};
