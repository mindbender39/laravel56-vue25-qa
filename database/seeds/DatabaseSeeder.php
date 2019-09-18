<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // seed db with fresh db tables run command: php artisan migrate:fresh --seed

        // $this->call(UsersTableSeeder::class);

        // to create 3 users in users table
        //factory(App\Models\User::class, 3)->create();

        // to create 3 users in users table and attach user_id with each question
        // that will generate using make() instead of create()
        factory(App\Models\User::class, 3)->create()->each(function ($user) {
            $user->questions()->saveMany(
                factory(App\Models\Question::class, rand(1, 5))->make()
            );
        });
    }
}
