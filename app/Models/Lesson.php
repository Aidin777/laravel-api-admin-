<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lesson extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function theme() :BelongsTo
    {
        return $this->BelongsTo(Theme::class);
    }
    public function presentation() :HasOne
    {
        return $this->hasOne(Presentation::class);
    }

    public function lessonVideo() :HasOne
    {
        return $this->hasOne(LessonVideo::class);
    }

    public function lessonTest() :HasOne
    {
        return $this->hasOne(LessonTest::class);
    }

    public function progress() :HasOne
    {
        return $this->hasOne(UserTestProgress::class);
    }
}
