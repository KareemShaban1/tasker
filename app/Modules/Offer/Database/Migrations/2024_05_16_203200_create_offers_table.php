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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_type_id')->constrained('task_types')->cascadeOnDelete();
            $table->double('offer');
            $table->string('description');
            $table->string('offer_limit',100);
            $table->boolean('is_active');
            $table->foreignId('language_id')->constrained('languages')->cascadeOnDelete();
            $table->withAuditFields();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};