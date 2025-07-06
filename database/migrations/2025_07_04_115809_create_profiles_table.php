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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->tinyInteger('nationality_id')->unsigned();
            $table->string('n_code', 15)->unique();
            $table->boolean('gender')->nullable();
            $table->string('f_name_fa', 30)->nullable();
            $table->string('l_name_fa', 40)->nullable();
            $table->string('nickname', 30)->nullable();
            $table->string('f_name_en', 40)->nullable();
            $table->string('l_name_en', 50)->nullable();
            $table->string('father', 40)->nullable();
            $table->string('sh_sh', 10)->nullable();
            $table->string('born_place', 30)->nullable();
            $table->string('born_date', 10)->nullable();
            $table->string('din', 20)->nullable();
            $table->string('mazhab', 20)->nullable();
            $table->tinyInteger('nezam_id')->unsigned()->nullable();
            $table->tinyInteger('taahol')->unsigned()->nullable();
            $table->tinyInteger('child_qty')->unsigned()->default(0);
            $table->tinyInteger('maghta_id')->unsigned()->nullable();
            $table->string('reshte', 30)->nullable();
            $table->string('address', 150)->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->string('image_url', 40)->nullable();
            $table->char('created', 19);
            $table->char('updated', 19)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
