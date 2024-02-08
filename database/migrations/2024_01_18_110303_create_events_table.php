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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title', 30);
            $table->string('description', 50)->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->dateTime('created_at');
            $table->string('created_by', 100);
            $table->dateTime('updated_at')->nullable();
            $table->string('updated_by', 100)->nullable();
            $table->foreignId('user_id')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
}
;
