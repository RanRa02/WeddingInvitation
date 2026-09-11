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
        Schema::table('weddings', function (Blueprint $table) {
            $table->string('groom_name_en')->nullable()->after('groom_name');
            $table->string('bride_name_en')->nullable()->after('bride_name');
            $table->string('lunar_date')->nullable()->after('event_date');
            $table->string('morning_time')->nullable()->after('lunar_date');
            $table->string('evening_time')->nullable()->after('morning_time');
            $table->string('bank_name')->nullable()->after('music_url');
            $table->string('bank_account_name')->nullable()->after('bank_name');
            $table->string('bank_account_number')->nullable()->after('bank_account_name');
            $table->string('bank_qr_image')->nullable()->after('bank_account_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('weddings', function (Blueprint $table) {
            $table->dropColumn([
                'groom_name_en',
                'bride_name_en',
                'lunar_date',
                'morning_time',
                'evening_time',
                'bank_name',
                'bank_account_name',
                'bank_account_number',
                'bank_qr_image'
            ]);
        });
    }
};
