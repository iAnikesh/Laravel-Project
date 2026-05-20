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
            $table->dropColumn(['bank_details', 'location_details']);

            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('city')->nullable();
            $table->string('pin_code')->nullable();
            $table->string('district')->nullable();
            $table->string('state')->nullable();

            $table->string('bank_account_number')->nullable();
            $table->string('bank_ifsc_code')->nullable();
            $table->string('bank_branch')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('bank_details')->nullable();
            $table->text('location_details')->nullable();

            $table->dropColumn([
                'address_1', 'address_2', 'city', 'pin_code', 'district', 'state',
                'bank_account_number', 'bank_ifsc_code', 'bank_branch',
            ]);
        });
    }
};
