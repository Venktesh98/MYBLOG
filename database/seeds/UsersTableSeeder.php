<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset the users table
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('users')->truncate();

        // generate 3 users/author
        DB::table('users')->insert([
            [
                'name' => "venky",
                'slug'=>"venky-soma",
                'email' => "vgs@test.com",
                'password' => bcrypt('secret')
            ],
            [
                'name' => "omni",
                'slug'=>"omni-metikel",
                'email' => "omni@test.com",
                'password' => bcrypt('secret')
            ],
            [
                'name' => "Bharu",
                'slug'=>"bharu-nakka",
                'email' => "bharu@test.com",
                'password' => bcrypt('secret')
            ],
        ]);
    }
}
