<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\{BelongsTo};

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['house_id', 'tenant', 'amount', 'paid', 'month', 'status'];

    protected $appends = ['is_paid'];

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }

    public function getIsPaidAttribute(): bool
    {
        return (int)$this->amount == (int)$this->paid;
    }
}
