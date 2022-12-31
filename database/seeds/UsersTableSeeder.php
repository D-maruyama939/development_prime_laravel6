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
        DB::table('users')->insert([
            'name' => 'sample1',
            'email' => 'abcd@gmail.com',
            'password' => 'abcd1234',
        ]);
    }
}
