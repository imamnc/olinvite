<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Invitation extends Model
{
    use HasFactory;
    protected $guarded = [];

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
}
