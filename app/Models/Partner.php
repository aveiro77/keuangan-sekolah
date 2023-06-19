<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Partner extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'address'];

    public function transactions(): HasMany
    {
        return $this->hasMany(transactions::class);
    }
}
