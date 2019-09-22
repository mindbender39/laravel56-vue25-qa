<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['body', 'user_id'];

    /* ACCESSORS */
    public function getBodyHtmlAttribute()
    {
        // convert markdown to html built-in after 5.5 >=
        return \Parsedown::instance()->text($this->body);
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
        return $this->id === $this->question->best_answer_id ? 'vote-accepted' : '';
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

        /* ELOQUENT EVENTS */
        // creating Laravel lifecycle hook: created(closure function which accepts current
        // model instance as argument)
        static::created(function ($answer) {
            // answers_count is a column of questions table
            $answer->question->increment('answers_count');
        });

        static::deleted(function ($answer) {
            $question = $answer->question;
            $question->decrement('answers_count');

            // another way to updated best_answer_id in questions table is by setting that column
            // as foreign key and when an answer delete it will set to null at DB level
            /*if ($question->best_answer_id === $answer->id) {
                $question->best_answer_id = null;
                $question->save();
            }*/
        });
    }
}
