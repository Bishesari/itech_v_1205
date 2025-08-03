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
        Schema::create('skill_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institute_id')->constrained()->cascadeOnDelete();
            $table->foreignId('skill_requester_id')->constrained()->cascadeOnDelete();
            $table->foreignId('skill_standard_id')->constrained()->cascadeOnDelete();
            $table->string('description', 150)->nullable();
            $table->char('created', 19);
            $table->char('updated', 19)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skill_requests');
    }
};
