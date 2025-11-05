<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseComment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'course_id',
        'commnet',
        'parent_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function parent()
    {
        return $this->belongsTo(CourseComment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(CourseComment::class, 'parent_id');
    }
}
