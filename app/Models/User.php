<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /* ACCESSORS */
    public function getUrlAttribute()
    {
        //return route('questions.show', $this->id);
        return '#';
    }

    public function getAvatarAttribute()
    {
        $email = $this->email;
        $size = 23;
        $default = asset('/images/avatar/user-1.jpg');

        return 'https://www.gravatar.com/avatar/'.md5(strtolower(trim($email)))."?s={$size}";
    }

    /* RELATIONSHIP */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function favorites()
    {
        // a user can have more than one favorite question
        /* as our table name is favorites not question_user so we must specify that name
           else query assume that our table name is question_user
           (in alphabetical order q first u last) */
        /* as we are following the convention like user_id and question_id so 3rd and 4th
           params are optional in this case */
        /* withTimestamps() is chained for created_at and updated_at columns to fill
           at the time to seed favorites table */
        return $this->belongsToMany(Question::class, 'favorites')->withTimestamps();  // user_id, question_id
    }
}
