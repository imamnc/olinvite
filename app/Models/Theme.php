<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Theme extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    /**
     * Get the invitation_type that owns the Theme
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invitation_type(): BelongsTo
    {
        return $this->belongsTo(InvitationType::class, 'invitation_type_id', 'id');
    }
}
