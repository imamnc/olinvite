<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WeddingData extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $with = ['galleries', 'stories', 'gift_channels'];

    // Cast groom photo
    protected function groomPhoto(): Attribute
    {
        return Attribute::make(get: fn ($value) => $value ? url($value) : url('img/noimage.jpg'));
    }

    // Cast bride photo
    protected function bridePhoto(): Attribute
    {
        return Attribute::make(get: fn ($value) => $value ? url($value) : url('img/noimage.jpg'));
    }

    // Cast custom field
    protected function customField(): Attribute
    {
        return Attribute::make(get: fn ($value) => $value ? json_decode($value) : null);
    }

    /**
     * Get the invitation that owns the WeddingData
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class, 'invitation_id', 'id');
    }

    /**
     * Get all of the galleries for the Invitation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class, 'invitation_id', 'invitation_id');
    }

    /**
     * Get all of the stories for the Invitation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stories(): HasMany
    {
        return $this->hasMany(Story::class, 'invitation_id', 'invitation_id');
    }

    /**
     * Get all of the gift_channels for the Invitation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gift_channels(): HasMany
    {
        return $this->hasMany(GiftChannel::class, 'invitation_id', 'invitation_id');
    }
}
