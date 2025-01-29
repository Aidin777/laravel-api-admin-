<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DuelQuestion extends Model
{
    protected $guarded = [];
    protected $hidden = [
        'id',
        'duel_id',
        "created_at",
        "updated_at",
        "question_id",
    ];

    public function question() : BelongsTo
    {
        return $this->BelongsTo(Question::class);
    }
    use HasFactory;
}
