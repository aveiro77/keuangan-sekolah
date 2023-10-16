<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory;
    protected $fillable = ['nisn', 'fullname', 'group', 'active_year_id', 'temp_status'];

    public function spp_transactions(): HasMany
    {
        return $this->hasMany(Spp_transactions::class);
    }

    public function active_year(): BelongsTo
    {
        return $this->belongsTo(ActiveYear::class);
    }
}
