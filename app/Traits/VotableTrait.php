<?php

namespace App\Traits;

use App\Models\User;

trait VotableTrait
{
    /* COMMON RELATIONSHIP IN QUESTION AND ANSWER */
    public function votes()
    {
        // 1st argument is the related model and 2nd will be table name
        // in case of morphe relationship we use singular pivot table name: votable
        return $this->morphToMany(User::class, 'votable');
    }

    /* COMMON OTHER FUNCTIONS IN QUESTION AND ANSWER */
    public function upVotes()
    {
        return $this->votes()->wherePivot('vote', 1);
    }

    public function downVotes()
    {
        return $this->votes()->wherePivot('vote', -1);
    }
}
