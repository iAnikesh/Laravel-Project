<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('application_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('housing_application_id')->constrained()->cascadeOnDelete();
            $table->string('stage');
            $table->unsignedTinyInteger('percentage');
            $table->text('notes')->nullable();
            $table->foreignId('recorded_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('application_progress');
    }
};
