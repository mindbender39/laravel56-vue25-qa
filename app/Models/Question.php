<?php

namespace App\Models;

use App\Traits\VotableTrait;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use VotableTrait;

    protected $fillable = [
        'title',
        'body'
    ];

    /* MUTATOR */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }

    /*public function setBodyAttribute($value)
    {
        // clean() function is an helper function from htmlpurifier to clean/remove malicious code
        // e.g: someone try to save <script>malicious code here</script>
        $this->attributes['body'] = clean($value);
    }*/

    /* ACCESSORS */
    public function getUrlAttribute()
    {
        return route('questions.show', $this->slug);
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
        if ($this->answers_count > 0) {
            if ($this->best_answer_id) {
                return 'answered-accepted';
            }
            return 'answered';
        }
        return 'unanswered';
    }

    public function getBodyHtmlAttribute()
    {
        // clean() function is an helper function from htmlpurifier to clean/remove malicious code
        // e.g: someone try to save <script>malicious code here</script>
        return clean($this->getbodyHtml());
    }

    private function getbodyHtml()
    {
        // convert markdown to html built-in after 5.5 >=
        return \Parsedown::instance()->text($this->body);
    }

    public function getExcerptAttribute()
    {
        return $this->excerpt();
    }

    public function excerpt($length=250)
    {
        return str_limit(strip_tags($this->getbodyHtml()), $length);
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    /* OTHER FUNCTIONS */
    public function acceptBestAnswer(Answer $answer)
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    public function isFavorited()
    {
        return $this->favorites()->where('user_id', auth()->id())->count() > 0;
    }

    /* RELATIONSHIP */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function favorites()
    {
        // a user can have more than one favorite question
        // as our table name is favorites not question_user so we must specify that name
        // else query assume that our table name is question_user
        // (in alphabetical order q first u last)
        // as we are following the convention like question_id and user_id so 3rd and 4th
        // params are optional in this case
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps(); // question_id, user_id
    }
}
