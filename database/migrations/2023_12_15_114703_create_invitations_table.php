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
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('theme_id')->nullable()->constrained('themes', 'id')->nullOnDelete();
            $table->string('prefix_route')->nullable();
            $table->string('code')->unique();
            $table->string('password');
            $table->string('password_default');
            $table->string('customer_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_published')->default(false);
            $table->boolean('is_form_open')->default(false);
            $table->timestamps();
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('expired_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
