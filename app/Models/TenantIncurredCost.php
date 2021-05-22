<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo};

class TenantIncurredCost extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['tenant_id', 'amount', 'date', 'note'];

    protected $dates = ['date'];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
