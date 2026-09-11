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
        Schema::create('page_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained('pages')->onDelete('cascade');
            $table->string('name');
            $table->string('name_kh')->nullable();
            $table->string('name_ch')->nullable();
            $table->string('route_name')->nullable();
            $table->string('type')->default('action'); // edit, edit_modal, destroy, view, etc.
            $table->string('position')->default('action'); // action, header, top
            $table->string('icon')->nullable();
            $table->string('parent')->nullable();
            $table->integer('order')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_actions');
    }
};
