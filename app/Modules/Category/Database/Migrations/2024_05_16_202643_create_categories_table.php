<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('task_type_id')->constrained('task_types')->cascadeOnDelete();
            $table->boolean('is_active');
            $table->foreignId('language_id')->constrained('languages')->cascadeOnDelete();
            $table->index(['name','task_type_id','is_active']);
            $table->withAuditFields();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
