<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\{HasMany, HasManyThrough};

class Building extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'location', 'default_rent', 'default_deposit', 'attributes', 'note'];

    public function houses(): HasMany
    {
        return $this->hasMany(House::class);
    }

    public function OccupiedHouses(): HasMany
    {
        return $this->hasMany(House::class)->occupied();
    }

    public function vacantHouses(): HasMany
    {
        return $this->hasMany(House::class)->vacant();
    }

    public function tenants(): HasManyThrough
    {
        return $this->hasManyThrough(Tenant::class, House::class);
    }

    public function payments(): HasManyThrough
    {
        return $this->hasManyThrough(Payment::class, House::class);
    }

    public function invoices(): HasManyThrough
    {
        return $this->hasManyThrough(Invoice::class, House::class);
    }

}
