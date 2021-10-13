<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
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
        $user = User::where('email', 'user@gmail.com')->first();
        if($user) {
            $now = Carbon::now()->toDateString();
            $company = new Company();
            $company->fill([
                'user_id' => $user['id'],
                'title' => "Title {$now}",
                'phone' => '+380960000000',
                'description' => "Title {$now} description",
            ])->save();
        }
    }
}
