<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachments extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->string('file', 255);
            $table->string('path', 255);
            $table->dateTime('created_at');
            $table->string('created_by', 100);
            $table->dateTime('updated_at')->nullable();
            $table->string('updated_by', 100)->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('events_id')->constrained('events');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
}
;
