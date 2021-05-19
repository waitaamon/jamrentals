<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo};
use Illuminate\Database\Eloquent\{Builder, Model, SoftDeletes};
use Illuminate\Support\Facades\DB;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code', 'house_id', 'user_id', 'tenant_id', 'amount', 'month', 'date_paid', 'status', 'note', 'reversed_on', 'reversed_by', 'reverse_note'
    ];

    protected $dates = ['month', 'date_paid', 'reversed_on'];

    public static function boot()
    {
        parent::boot();

        static::creating(function (Payment $payment) {
            DB::transaction(function () use ($payment) {
                $paymentsInSequence = Payment::query()->whereBetween('created_at', [
                    now()->startOfYear(),
                    now()->endOfYear(),
                ])->lockForUpdate()->count();

                $payment->code = date('Y')."-0000000".sprintf('%07d', $paymentsInSequence + 1);

            });
        });

    }

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reversedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reversed_by');
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }
}
