<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Cast file path
    protected function path(): Attribute
    {
        return Attribute::make(get: fn ($value) => $value ? url($value) : url('img/noimage.jpg'));
    }
}
