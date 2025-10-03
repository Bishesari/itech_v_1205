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
        Schema::create('mobiles', function (Blueprint $table) {
            $table->id();
            $table->string('mobile_nu', 11)->unique();
            $table->string('otp', 10)->nullable();
            $table->tinyInteger('otp_sent_qty')->default(0);
            $table->unsignedInteger('otp_next_try_time')->default(0);
            $table->boolean('verified')->default(0);
            $table->string('created', 19)->nullable();
            $table->string('updated', 19)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobiles');
    }
};
