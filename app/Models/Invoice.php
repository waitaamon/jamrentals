<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\{BelongsTo};

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['house_id', 'tenant_id', 'amount', 'paid', 'balance', 'month', 'status'];

    protected $appends = ['is_paid'];

    protected $dates = ['month'];

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function getIsPaidAttribute(): bool
    {
        return (int)$this->balance == 0;
    }
}
