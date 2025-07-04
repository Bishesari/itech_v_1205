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
        Schema::create('skill_standards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('field_id')->constrained('fields')->onDelete('cascade');
            $table->string('code', 15)->unique();
            $table->string('name_fa', 50);
            $table->string('name_en', 50);
            $table->string('abb', 25);
            $table->decimal('nazari_h', 5,1)->default(0);
            $table->decimal('amali_h', 5, 1)->default(0);
            $table->decimal('karvarzi_h', 5, 1)->default(0);
            $table->decimal('project_h', 5, 1)->default(0);
            $table->decimal('sum_h', 6, 1)->default(0);
            $table->decimal('required_h', 6, 1)->default(0);
            $table->boolean('is_active')->default(true);
            $table->char('created', 19);
            $table->char('updated', 19)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skill_standards');
    }
};
