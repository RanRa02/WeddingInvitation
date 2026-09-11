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
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('side')->default('both'); // groom, bride, both
            $table->string('table_number')->nullable();
            $table->string('attendance')->default('pending'); // pending, attending, declined
            $table->integer('companions')->default(1);
            $table->text('wishes')->nullable();
            $table->string('gift_amount')->nullable();
            $table->string('invitation_code')->nullable()->unique();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
