<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    protected $fillable = [
        'quiz_id',
        'type',
        'question_text',
        'options',
        'correct_answer',
        'points'
    ];

    protected $casts = [
        'options' => 'array',
        'correct_answer' => 'array'
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}
