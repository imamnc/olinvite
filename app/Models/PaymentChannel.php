<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentChannel extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $with = ['bank_channel'];

    /**
     * Get the bank that owns the PaymentChannel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bank_channel(): BelongsTo
    {
        return $this->belongsTo(BankChannel::class, 'bank_channel_id', 'id');
    }
}
