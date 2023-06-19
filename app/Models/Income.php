<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Income extends Model
{
    use HasFactory;
    protected $fillable = ['trn', 'date', 'description', 'coa_id', 'user_id', 'source', 'amount'];

    public function coa(): BelongsTo
    {
        return $this->belongsTo(Coa::class);
    }

    public function income(): BelongsTo
    {
        return $this->belongsTo(Income::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
