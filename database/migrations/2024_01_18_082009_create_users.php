<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsers extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 30);
            $table->string('password', 60)->nullable();
            $table->string('name', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('nip', 16)->nullable();
            $table->string('unit', 30)->nullable();
            $table->string('image')->nullable();
            $table->integer('role')->default(1);
            $table->string('bio', 100)->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->boolean('is_ldap')->default(false);
            $table->string('created_at', 100)->nullable();
            $table->string('updated_at', 100)->nullable();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}
;
