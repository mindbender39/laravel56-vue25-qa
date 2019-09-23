<?php

use Illuminate\Database\Seeder;

class UsersQuestionsAnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // to create 3 users in users table
        //factory(App\Models\User::class, 3)->create();

        // to create 3 users in users table and attach user_id with each question
        // that will generate using make() instead of create()
        /*factory(App\Models\User::class, 3)->create()->each(function ($user) {
            $user->questions()->saveMany(
                factory(App\Models\Question::class, rand(1, 5))->make()
            );
        });*/

        /* Laravel create() method is created the model instance and save data in the database.
         * make() function has created the instance of the class.
         * */

        // delete in revers order so the foreign key error not occur.
        \DB::table('answers')->delete();
        \DB::table('questions')->delete();
        \DB::table('users')->delete();

        factory(App\Models\User::class, 3)->create()->each(function ($user) {
            $user->questions()->saveMany(
                factory(App\Models\Question::class, rand(1, 5))->make()
            )->each(function ($question) {
                $question->answers()->saveMany(
                    factory(\App\Models\Answer::class, rand(1, 5))->make()
                );
            });
        });
    }
}
