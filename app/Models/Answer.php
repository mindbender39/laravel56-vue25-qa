<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    /* ACCESSORS */
    public function getBodyHtmlAttribute()
    {
        // convert markdown to html built-in after 5.5 >=
        return \Parsedown::instance()->text($this->body);
    }

    /* RELATIONSHIP */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public static function boot()
    {
        parent::boot();

        // creating Laravel lifecycle hook: created(closure function which accepts current model instance as argument)
        static::created(function ($answer) {
            // answers_count is a column of questions table
            $answer->question->increment('answers_count');
        });
    }
}
