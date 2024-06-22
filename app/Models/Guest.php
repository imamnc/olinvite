<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Guest extends Model
{
    use HasFactory;

    protected $with = ['wishes', 'rsvp', 'log_sends', 'log_visits'];

    /**
     * Get the invitation that owns the Guest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class, 'invitation_id', 'id');
    }

    /**
     * Get all of the wishes for the Guest
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wishes(): HasMany
    {
        return $this->hasMany(Wish::class, 'guest_id', 'id');
    }

    /**
     * Get the rsvp associated with the Guest
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function rsvp(): HasOne
    {
        return $this->hasOne(Rsvp::class, 'guest_id', 'id');
    }

    /**
     * Get all of the log_sends for the Guest
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function log_sends(): HasMany
    {
        return $this->hasMany(LogSendLink::class, 'guest_id', 'id');
    }

    /**
     * Get all of the log_visits for the Guest
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function log_visits(): HasMany
    {
        return $this->hasMany(LogVisitLink::class, 'guest_id', 'id');
    }
}
