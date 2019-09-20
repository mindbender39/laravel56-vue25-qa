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
}
