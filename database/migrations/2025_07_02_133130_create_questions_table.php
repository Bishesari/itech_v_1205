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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('level_id');   // درجه سختی سوال
            $table->foreignId('type_id');   // نوع سوال متنی یا عکس
            $table->string('text'); // متن سوال
            $table->string('description')->nullable(); // توضیح پاسخ سوال
            $table->char('created', 19);
            $table->char('updated', 19)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
