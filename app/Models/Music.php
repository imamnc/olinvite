<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Music extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    // Cast file path
    protected function filePath(): Attribute
    {
        return Attribute::make(get: fn ($value) => $value ? url($value) : null);
    }

    /**
     * Get all of the invitations for the Music
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class, 'music_id', 'id');
    }
}
