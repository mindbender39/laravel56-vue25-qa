<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Question;
use App\Models\Answer;

class VotablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //\DB::table('votables')->where('votable_type', 'App\Models\Question')->delete();
        \DB::table('votables')->delete();

        $users = User::all();
        $numberOfUsers = $users->count();
        $votes = [-1, 1];
        $questions = Question::all();
        $answers = Answer::all();

        foreach ($questions as $question) {
            for ($i=0; $i<rand(1, $numberOfUsers); $i++) {
                $user = $users[$i];

                $user->voteQuestion($question, $votes[rand(0, 1)]);
            }
        }

        foreach ($answers as $answer) {
            for ($i=0; $i<rand(1, $numberOfUsers); $i++) {
                $user = $users[$i];

                $user->voteAnswer($answer, $votes[rand(0, 1)]);
            }
        }
    }
}
