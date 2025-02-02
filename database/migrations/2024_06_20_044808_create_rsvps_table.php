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
        Schema::create('rsvps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained('invitations', 'id')->cascadeOnDelete();
            $table->foreignId('guest_id')->constrained('guests', 'id')->cascadeOnDelete();
            $table->integer('person')->nullable()->comment('Number of person who will come');
            $table->enum('confirmation', ['hadir', 'tidak', 'ragu']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rsvps');
    }
};
