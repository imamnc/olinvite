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
        Schema::create('log_send_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guest_id')->constrained('guests', 'id')->cascadeOnDelete();
            $table->enum('send_method', ['whatsapp_direct', 'whatsapp_api', 'email']);
            $table->boolean('is_success');
            $table->text('errors')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_send_links');
    }
};
