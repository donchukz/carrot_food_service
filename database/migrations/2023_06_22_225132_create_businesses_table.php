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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->index();
            $table->unsignedBigInteger('business_owner_id')->nullable();
            $table->foreign('business_owner_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->string('description')->index()->nullable();
            $table->string('location', 100)->index()->nullable();
            $table->string('phone_number', 20)->index()->nullable();
            $table->string('status', 50)->default('ACTIVE')->index()->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
