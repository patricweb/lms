<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
