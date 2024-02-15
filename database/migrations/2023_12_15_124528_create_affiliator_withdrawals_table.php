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
        Schema::create('affiliator_withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_affiliator_id')->nullable()->constrained('wallet_affiliators', 'id')->nullOnDelete();
            $table->decimal('nominal', 19, 2);
            $table->boolean('is_paid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliator_withdrawals');
    }
};
