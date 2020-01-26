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
        \App\User::create([
            'name'      => 'Nizam',
            'email'     => 'user@royalgroup.com.bd',
            'password'  => bcrypt(123456)
        ]);
        $this->call(UsersTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
    }
}
