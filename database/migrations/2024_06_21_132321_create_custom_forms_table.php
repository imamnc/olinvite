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
        Schema::create('custom_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_type_id')->constrained('form_types', 'id')->cascadeOnDelete();
            $table->foreignId('theme_id')->constrained('themes', 'id')->cascadeOnDelete();
            $table->string('name');
            $table->string('key_name')->comment('JSON key data name');
            $table->string('default_value')->nullable()->comment('Default value of JSON data');
            $table->boolean('is_required')->default(false);
            $table->timestamps();
        });
    }

/**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_forms');
    }
};
