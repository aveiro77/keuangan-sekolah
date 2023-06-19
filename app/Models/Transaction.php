<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['trn', 'date', 'description', 'partner_id', 'coa_id', 'user_id', 'sub_total', 'tax', 'ppn', 'grand_total'];

    public function coa(): BelongsTo
    {
        return $this->belongsTo(Coa::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function due(): BelongsTo
    {
        return $this->belongsTo(Due::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function transaction_details(): HasMany
    {
        return $this->hasMany(Transaction_details::class);
    }
}
