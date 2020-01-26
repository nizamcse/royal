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
        \App\User::create([
            'name'  => 'Super Admin',
            'email' => 'nizam@winskit.com',
            'password'  => bcrypt(123456),
            'super_admin'   => 1,
        ]);


        \App\User::create([
            'name'  => 'Admin',
            'email' => 'admin@royalgroup.com.bd',
            'password'  => bcrypt(123456),
        ]);

        \App\User::create([
            'name'  => 'Admin',
            'email' => 'admin@test.com.bd',
            'password'  => bcrypt(123456),
        ]);
    }
}
