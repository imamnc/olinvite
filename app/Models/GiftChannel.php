<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GiftChannel extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $with = ['bank_channel'];

    /**
     * Get the bank_channel that owns the GiftChannel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bank_channel(): BelongsTo
    {
        return $this->belongsTo(BankChannel::class, 'bank_channel_id', 'id');
    }

    /**
     * Get all of the gifts for the Invitation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gifts(): HasMany
    {
        return $this->hasMany(Gift::class, 'gift_channel_id', 'id');
    }
}
