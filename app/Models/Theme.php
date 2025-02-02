<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Theme extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $with = ['invitation_type', 'custom_forms'];

    // Cast thumbnails attribute
    protected function thumbnails(): Attribute
    {
        return Attribute::make(get: fn ($value) => $value ? url($value) : null);
    }

    /**
     * Get the invitation_type that owns the Theme
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invitation_type(): BelongsTo
    {
        return $this->belongsTo(InvitationType::class, 'invitation_type_id', 'id');
    }

    /**
     * Get all of the invitations for the Theme
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class, 'theme_id', 'id');
    }

    /**
     * Get all of the custom_forms for the Theme
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function custom_forms(): HasMany
    {
        return $this->hasMany(CustomForm::class, 'theme_id', 'id');
    }
}
