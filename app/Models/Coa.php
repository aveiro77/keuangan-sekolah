<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Coa extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'name', 'initial_balance', 'active_year_id'];

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

    public function active_year(): BelongsTo
    {
        return $this->belongsTo(ActiveYear::class);
    }
}
