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
        Schema::create('weddings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('groom_name');
            $table->string('bride_name');
            $table->string('groom_parents')->nullable();
            $table->string('bride_parents')->nullable();
            $table->dateTime('event_date')->nullable();
            $table->string('venue_name')->nullable();
            $table->text('venue_address')->nullable();
            $table->text('venue_location_url')->nullable();
            $table->string('theme_template')->default('married'); // married, sapphire, ruby
            $table->string('cover_image')->nullable();
            $table->string('music_url')->nullable();
            $table->json('schedule')->nullable();
            $table->json('settings')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weddings');
    }
};
