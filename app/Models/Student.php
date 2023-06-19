<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;
    protected $fillable = ['nisn', 'fullname', 'group', 'year'];

    public function spp_transactions(): HasMany
    {
        return $this->hasMany(Spp_transactions::class);
    }
}
