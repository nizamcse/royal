<?php

use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::where('email','=','admin@royalgroup.com.bd')->first();
        $user_2 = \App\User::where('email','=','admin@test.com.bd')->first();
        $company_1 = \App\Model\Company::create([
            'name'          => 'Royal Firm',
            'address'       => '',
            'contact_no'    => '',
            'email'         => ''
        ]);
        $company_2 = \App\Model\Company::create([
            'name'          => 'Royal Metal',
            'address'       => '',
            'contact_no'    => '',
            'email'         => ''
        ]);
        $company_3 = \App\Model\Company::create([
            'name'          => 'Shahara Group',
            'address'       => '',
            'contact_no'    => '',
            'email'         => ''
        ]);
        $company_4 = \App\Model\Company::create([
            'name'          => 'Royap Ply Board',
            'address'       => '',
            'contact_no'    => '',
            'email'         => ''
        ]);
        $company_4 = \App\Model\Company::create([
            'name'          => 'Royap Group',
            'address'       => '',
            'contact_no'    => '',
            'email'         => ''
        ]);

        $company_5 = \App\Model\Company::create([
            'name'          => 'Test Group',
            'address'       => '',
            'contact_no'    => '',
            'email'         => ''
        ]);

        $user->companies()->sync([
            $company_1->id => ['is_admin' => 1],
            $company_2->id => ['is_admin' => 1],
            $company_3->id => ['is_admin' => 1],
            $company_4->id => ['is_admin' => 1],
        ]);

        $user_2->companies()->sync([
            $company_5->id => ['is_admin' => 1],
        ]);

    }
}
