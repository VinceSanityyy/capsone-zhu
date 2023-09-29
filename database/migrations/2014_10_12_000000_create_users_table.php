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
            $table->string('id_number')->nullable()->unique();
            $table->foreignId('course_id')->nullable()->constrained();
            $table->string('phone_number')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('address')->nullable();
            $table->string('gender')->nullable();
            $table->string('birthday')->nullable();
            $table->string('subject_code')->nullable();
            $table->string('school_year')->nullable();
            $table->string('degree_type')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_active')->default(false);
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
