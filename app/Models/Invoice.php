<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Invoice extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $with = ['payment'];

    /**
     * Get the invitation that owns the Invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class, 'invitation_id', 'id');
    }

    /**
     * Get the payment associated with the Invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class, 'invoice_id', 'id');
    }
}
