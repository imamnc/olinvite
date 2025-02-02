<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    // Cast file path
    protected function picturePath(): Attribute
    {
        return Attribute::make(get: fn ($value) => $value ? url($value) : url('img/noimage.jpg'));
    }
}
