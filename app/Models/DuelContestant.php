<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DuelContestant extends Model
{
    use HasFactory;
    protected $casts = [
        'scoreboard' => 'array',
        'isComplete' => 'boolean',
    ];

    protected $hidden = [
        'id',
        'duel_id',
        "created_at",
        "updated_at",
    ];
    protected $guarded = [];

    public function user() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    public function duel() : BelongsTo
    {
        return $this->BelongsTo(Duel::class);
    }
}
