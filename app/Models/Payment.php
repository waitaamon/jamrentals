<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo};
use Illuminate\Database\Eloquent\{Builder, Model, SoftDeletes};

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['house_id', 'user_id', 'reversed_by', 'tenant', 'amount', 'is_deposit', 'month', 'date_paid', 'status'];

    protected $dates = ['month', 'date_paid'];

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reversedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reversed_by');
    }

    public function scopeDeposit(Builder $query): Builder
    {
        return $query->where('is_deposit', true);
    }

    public function scopeRent(Builder $query): Builder
    {
        return $query->where('is_deposit', false);
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }
}
