<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankChannel extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    // Cast logo attribute
    protected function logo(): Attribute
    {
        return Attribute::make(get: fn ($value) => $value ? url($value) : url('img/noimage.jpg'));
    }

    /**
     * Get all of the payment_channels for the BankChannel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payment_channels(): HasMany
    {
        return $this->hasMany(PaymentChannel::class, 'bank_channel_id', 'id');
    }
}
