<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Spp_transaction extends Model
{
    use HasFactory;

    protected $fillable = ['trn', 'date', 'amount', 'student_id',    'coa_id', 'user_id', 'due_id', 'description'];

    public function coa(): BelongsTo
    {
        return $this->belongsTo(Coa::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function due(): BelongsTo
    {
        return $this->belongsTo(Due::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
