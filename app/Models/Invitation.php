<?php

namespace App\Models;

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
