<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUserActivities extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_activities', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->timestamp('time')
                ->default(DB::raw('CURRENT_TIMESTAMP'))
                ->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
            $table->enum('activity', ['login', 'logout']);
            $table->foreignId('user_id')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_activities');
    }
}
;
