<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Builder, Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class Tenant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['house_id', 'name', 'id_number', 'phone', 'deposit', 'note', 'status', 'invoice_from'];

    protected $appends = ['balance'];

    protected $dates = ['invoice_from'];

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function approvedPayments()
    {
        return $this->payments()->approved();
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function incurredCost(): HasMany
    {
        return $this->hasMany(TenantIncurredCost::class);
    }

    public function hasBalance(): bool
    {
        return $this->invoices()->where('balance', '>',0)->exists();
    }

    public function getBalanceAttribute()
    {
        return $this->invoices()->sum('amount') - $this->approvedPayments()->sum('amount');
    }

    public function scopeIsActive(Builder  $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeIsInActive(Builder  $query): Builder
    {
        return $query->where('status', 'inactive');
    }
}
