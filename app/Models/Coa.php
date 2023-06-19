<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coa extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'name', 'tcode', 'year'];

    public function spp_transactions(): HasMany
    {
        return $this->hasMany(Spp_transactions::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(transactions::class);
    }

    public function mutations(): HasMany
    {
        return $this->hasMany(mutations::class);
    }

    public function incomes(): HasMany
    {
        return $this->hasMany(incomes::class);
    }
}
