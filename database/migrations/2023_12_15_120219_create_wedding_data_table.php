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
            // Invitation ID
            $table->foreignId('invitation_id')->constrained('invitations', 'id')->cascadeOnDelete();
            // Grooms
            $table->string('groom_photo')->nullable();
            $table->string('groom_nickname')->nullable();
            $table->string('groom_name')->nullable();
            $table->string('groom_birthday')->nullable();
            $table->string('groom_birthplace')->nullable();
            $table->string('groom_father')->nullable();
            $table->string('groom_mother')->nullable();
            // Bride
            $table->string('bride_photo')->nullable();
            $table->string('bride_nickname')->nullable();
            $table->string('bride_name')->nullable();
            $table->string('bride_birthday')->nullable();
            $table->string('bride_birthplace')->nullable();
            $table->string('bride_father')->nullable();
            $table->string('bride_mother')->nullable();
            // Countdown
            $table->timestamp('countdown_date')->nullable();
            // Quotes
            $table->text('quotes')->nullable();
            $table->string('quotes_by')->nullable();
            // Video
            $table->text('youtube_video')->nullable();
            // Akad
            $table->date('akad_date')->nullable();
            $table->time('akad_start')->nullable();
            $table->time('akad_end')->nullable();
            $table->text('akad_place')->nullable();
            $table->text('akad_maps')->nullable();
            // Reception
            $table->date('reception_date')->nullable();
            $table->time('reception_start')->nullable();
            $table->time('reception_end')->nullable();
            $table->text('reception_place')->nullable();
            $table->text('reception_maps')->nullable();
            // Gift address
            $table->text('gift_address')->nullable();
            // To save custom fields as json
            $table->json('custom_field')->nullable();
            // Features activation
            $table->boolean('quotes_feature')->default(true);
            $table->boolean('video_feature')->default(true);
            $table->boolean('akad_feature')->default(true);
            $table->boolean('reception_feature')->default(true);
            $table->boolean('gift_feature')->default(true);
            $table->boolean('gallery_feature')->default(true);
            $table->boolean('wish_feature')->default(true);
            $table->boolean('rsvp_feature')->default(true);
            $table->boolean('story_feature')->default(true);
            $table->boolean('countdown_feature')->default(true);
            $table->boolean('music_feature')->default(true);
            $table->boolean('custom_music_feature')->default(false);
            // Timestamps
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
