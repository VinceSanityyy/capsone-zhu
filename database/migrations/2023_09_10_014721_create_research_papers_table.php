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
        Schema::create('research_papers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('user_id')->constrained(); //student
            $table->foreignId('course_id')->constrained();
            $table->string('adviser'); //part ni sa users na adviser or dili?
            $table->text('proposal_form')->nullable();
            $table->text('endorsment_form')->nullable();
            $table->text('receipt')->nullable();
            $table->unsignedTinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('research_papers');
    }
};
