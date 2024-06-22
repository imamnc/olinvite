<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Invitation extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $guard = 'invitation';
    protected $guarded = [];
    protected $hidden = ['password', 'password_default'];

    // Cast custom music path
    protected function customMusicPath(): Attribute
    {
        return Attribute::make(get: fn ($value) => $value ? url($value) : null);
    }

    /**
     * Get all of the guests for the Invitation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class, 'invitation_id', 'id');
    }

    /**
     * Get all of the wishes for the Invitation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wishes(): HasMany
    {
        return $this->hasMany(Wish::class, 'invitation_id', 'id');
    }

    /**
     * Get all of the log_visits for the Invitation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function log_visits(): HasMany
    {
        return $this->hasMany(LogVisitLink::class, 'invitation_id', 'id');
    }

    /**
     * Get the invoice associated with the Invitation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class, 'invitation_id', 'id');
    }

    /**
     * Get the theme that owns the Invitation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class, 'theme_id', 'id');
    }

    /**
     * Get the music that owns the WeddingData
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function music(): BelongsTo
    {
        return $this->belongsTo(Music::class, 'music_id', 'id');
    }

    /**
     * Get the wedding_data associated with the Invitation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function wedding_data(): HasOne
    {
        return $this->hasOne(WeddingData::class, 'invitation_id', 'id');
    }
}
