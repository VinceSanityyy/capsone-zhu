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
        Schema::create('endorsments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('research_paper_id')->constrained();
            $table->foreignId('user_id')->constrained(); //owner of the file
            $table->string('file_path')->nullable();
            $table->string('stage_submitted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('endorsments');
    }
};
