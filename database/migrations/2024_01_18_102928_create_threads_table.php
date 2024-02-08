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
        Schema::create('threads', function (Blueprint $table) {
            $table->id();
            $table->string('title', 30);
            $table->text('content');
            $table->string('file', 255)->nullable();
            $table->enum('status', ['approved', 'pending', 'rejected'])->default('pending');
            $table->dateTime('created_at');
            $table->string('created_by', 100);
            $table->dateTime('updated_at')->nullable();
            $table->string('updated_by', 100)->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('forum_type_id')->constrained('forum_types');
            $table->foreignId('thread_category_id')->constrained('thread_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('threads');
    }
}
;
