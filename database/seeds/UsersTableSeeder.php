<?php

use Illuminate\Database\Seeder;
use Faker\Factory;

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

        $faker = Factory::create(); # creating the faker object for the bio of user

        // generate 3 users/author
        DB::table('users')->insert([
            [
                'name' => "venky",
                'slug'=>"venky-soma",
                'email' => "vgs@test.com",
                'password' => bcrypt('secret'),
                'bio'=>$faker->text(rand(250,300)),
            ],
            [
                'name' => "omni",
                'slug'=>"omni-metikel",
                'email' => "omni@test.com",
                'password' => bcrypt('secret'),
                'bio'=>$faker->text(rand(250,300)),
            ],
            [
                'name' => "Bharu",
                'slug'=>"bharu-nakka",
                'email' => "bharu@test.com",
                'password' => bcrypt('secret'),
                'bio'=>$faker->text(rand(250,300)),
            ],
        ]);
    }
}
