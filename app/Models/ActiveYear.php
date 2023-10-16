<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ActiveYear extends Model
{
    use HasFactory;
    protected $fillable = ['year', 'period', 'active'];

    public function coa(): HasMany
    {
        return $this->hasMany(Coa::class);
    }

    public function student(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function due(): HasMany
    {
        return $this->hasMany(Due::class);
    }
}
