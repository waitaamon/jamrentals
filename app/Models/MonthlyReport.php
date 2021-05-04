<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\{BelongsTo};

class MonthlyReport extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['building_id', 'month', 'debtors', 'vacant_houses'];

    protected $dates = ['month'];

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }
}
