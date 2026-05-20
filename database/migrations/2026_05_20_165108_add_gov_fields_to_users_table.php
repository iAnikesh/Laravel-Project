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
        Schema::table('users', function (Blueprint $table) {
            $table->string('unique_user_id')->nullable()->unique()->after('id');
            $table->string('phone')->nullable()->after('email');
            $table->string('aadhaar_number')->nullable()->after('phone');
            $table->text('bank_details')->nullable()->after('aadhaar_number');
            $table->text('location_details')->nullable()->after('bank_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'unique_user_id',
                'phone',
                'aadhaar_number',
                'bank_details',
                'location_details',
            ]);
        });
    }
};
