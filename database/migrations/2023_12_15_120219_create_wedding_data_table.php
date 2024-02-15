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
        Schema::create('wedding_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained('invitations', 'id')->cascadeOnDelete();
            // Grooms
            $table->string('groom_name');
            $table->string('groom_birthday')->nullable();
            $table->string('groom_birthplace')->nullable();
            $table->string('groom_father')->nullable();
            $table->string('groom_mother')->nullable();
            // Bride
            $table->string('bride_name');
            $table->string('bride_birthday')->nullable();
            $table->string('bride_birthplace')->nullable();
            $table->string('bride_father')->nullable();
            $table->string('bride_mother')->nullable();
            // Quotes
            $table->text('quotes')->nullable();
            // Video
            $table->text('youtube_video')->nullable();
            // Akad
            $table->date('akad_date')->nullable();
            $table->time('akad_start')->nullable();
            $table->time('akad_end')->nullable();
            $table->time('akad_place')->nullable();
            $table->time('akad_maps')->nullable();
            // Reception
            $table->date('reception_date')->nullable();
            $table->time('reception_start')->nullable();
            $table->time('reception_end')->nullable();
            $table->time('reception_place')->nullable();
            $table->time('reception_maps')->nullable();
            // Gift address
            $table->text('gift_address')->nullable();
            // Music
            $table->foreignId('music_id')->nullable()->constrained('music', 'id')->nullOnDelete();
            $table->string('custom_music_path')->nullable();
            // Timestamp
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wedding_data');
    }
};
