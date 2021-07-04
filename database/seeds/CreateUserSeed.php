<?php

use Illuminate\Database\Seeder;
use App\User;

class CreateUserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "name" => "Admin",
            "username"=> "admin01",
            "password"=> bcrypt("password"),
            "aksess"=> "purchasing",
        ]);
    }
}
