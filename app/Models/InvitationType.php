<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvitationType extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    /**
     * Get all of the themes for the InvitationType
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function themes(): HasMany
    {
        return $this->hasMany(Theme::class, 'invitation_type_id', 'id');
    }
}
