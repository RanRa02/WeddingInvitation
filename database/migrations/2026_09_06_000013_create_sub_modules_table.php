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
        if (!Schema::hasTable('sub_modules')) {
            Schema::create('sub_modules', function (Blueprint $table) {
                $table->id();
                $table->foreignId('module_id')->constrained('modules')->onDelete('cascade');
                $table->string('name');
                $table->string('name_kh')->nullable();
                $table->string('icon')->default('fa-folder');
                $table->integer('sort_order')->default(0);
                $table->string('status')->default('active');
                $table->timestamps();
            });
        }

        if (Schema::hasTable('pages') && !Schema::hasColumn('pages', 'sub_module_id')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->foreignId('sub_module_id')->nullable()->after('module_id')->constrained('sub_modules')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('pages') && Schema::hasColumn('pages', 'sub_module_id')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->dropForeign(['sub_module_id']);
                $table->dropColumn('sub_module_id');
            });
        }
        Schema::dropIfExists('sub_modules');
    }
};
