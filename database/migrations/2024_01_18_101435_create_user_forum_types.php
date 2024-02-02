<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserForumTypes extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_forum_types', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('forum_type_id')->constrained('forum_types');

            $table->primary(['user_id', 'forum_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_forum_types');
    }
}
