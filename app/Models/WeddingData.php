<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeddingData extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the invitation that owns the WeddingData
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class, 'invitation_id', 'id');
    }
}
