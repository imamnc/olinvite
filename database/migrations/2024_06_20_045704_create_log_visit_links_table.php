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
        Schema::create('log_visit_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained('invitations', 'id')->cascadeOnDelete();
            $table->foreignId('guest_id')->constrained('guests', 'id')->cascadeOnDelete();
            $table->string('os')->nullable();
            $table->string('browser')->nullable();
            $table->string('location')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_visit_links');
    }
};
