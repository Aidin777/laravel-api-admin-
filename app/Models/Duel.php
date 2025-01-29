<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Duel extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function duelContestants() : HasMany
    {
        return $this->hasMany(DuelContestant::class);
    }
    public function questions() : HasMany
    {
        return $this->hasMany(DuelQuestion::class);
    }
}
