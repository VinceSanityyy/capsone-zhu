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
