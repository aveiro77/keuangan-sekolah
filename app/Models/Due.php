<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Due extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'total_amount', 'group', 'year'];

    public function spp_transactions(): HasMany
    {
        return $this->hasMany(Spp_transactions::class);
    }
}
