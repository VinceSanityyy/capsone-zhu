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
        // files must be polymorphic in the futer=reerrerereerer
        Schema::create('research_papers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('user_id')->constrained(); //student
            $table->foreignId('adviser_id')->nullable()->constrained('users'); //adviser
            $table->text('document')->nullable();
            $table->text('endorsement')->nullable();
            $table->text('receipt')->nullable();
            $table->boolean('for_scheduling')->default(false);
            $table->boolean('is_approved_by_adviser')->default(false);
            $table->string('status');
            $table->boolean('has_submitted_manuscript')->default(false);
            $table->boolean('has_submitted_cd')->default(false);
            $table->boolean('has_submitted_final_receipt')->default(false);
            $table->boolean('has_submitted_printed_materials')->default(false);
            $table->boolean('has_paid_final_adviser_fee')->default(false);
            $table->integer('plagiarism_counter')->default(0);
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
