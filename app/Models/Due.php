<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Due extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'total_amount', 'group', 'active_year_id', 'type'];

    public function spp_transactions(): HasMany
    {
        return $this->hasMany(Spp_transactions::class);
    }

    public function active_year(): BelongsTo
    {
        return $this->belongsTo(ActiveYear::class);
    }
}
