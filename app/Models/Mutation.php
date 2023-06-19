<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mutation extends Model
{
    use HasFactory;
    protected $fillable = ['trn', 'date', 'description', 'coa_id', 'coa_id2', 'coa2', 'user_id', 'debit', 'credit', 'stack'];

    public function coa(): BelongsTo
    {
        return $this->belongsTo(Coa::class);
    }

    public function mutation(): BelongsTo
    {
        return $this->belongsTo(Mutation::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
