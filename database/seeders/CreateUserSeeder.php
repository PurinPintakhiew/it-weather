<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => 'Admin',
                'email' => 'it61@bru.ac.th',
                'is_admin' => '1',
                'password' => bcrypt('itbru2561'),
            ]
        ];

        foreach($user as $key => $value){
            User::create($value);
        }

    }
}
