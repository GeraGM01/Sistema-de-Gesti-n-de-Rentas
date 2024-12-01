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
        Schema::table('propiedad', function (Blueprint $table) {
            $table->foreignId('rented_by')->nullable()->constrained('users')->onDelete('set null');
            $table->date('rented_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('propiedad', function (Blueprint $table) {
            $table->dropForeign(['rented_by']);
            $table->dropColumn('rented_by', 'rented_at');
        });
    }
};
