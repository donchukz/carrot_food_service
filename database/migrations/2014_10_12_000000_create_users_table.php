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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100)->index();
            $table->string('middle_name', 100)->index()->nullable();
            $table->string('last_name')->index()->nullable();
            $table->string('email', 100)->unique()->nullable();
            $table->string('address', 100)->index()->nullable();
            $table->string('phone_number', 20)->index()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('type', 50)->index()->nullable();
            $table->string('status', 50)->default('ACTIVE')->index()->nullable();
            $table->string('gender', 20)->index()->nullable();
            $table->string('dob', 20)->index()->nullable();
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
