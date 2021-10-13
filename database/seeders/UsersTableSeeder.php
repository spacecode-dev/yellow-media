<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'user@gmail.co')->first();
        if(!$user) {
            $user = new User();
            $user->fill([
                'first_name' => 'Colin',
                'last_name' => 'Coleman',
                'name' => 'Colin Coleman',
                'email' => 'user@gmail.com',
                'password' => Hash::make('password'),
                'phone' => '+380960000000',
            ])->save();
        }
    }
}
