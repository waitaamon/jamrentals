<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Builder, Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class House extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['building_id', 'name', 'rent', 'deposit', 'tenant', 'tenant_phone', 'tenant_id', 'is_occupied'];

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function approvedPayments()
    {
        return $this->payments()->approved();
    }

    public function scopeOccupied(Builder $query):Builder
    {
        return $query->where('is_occupied', true);
    }

    public function scopeVacant(Builder $query):Builder
    {
        return $query->where('is_occupied', false);
    }
}
