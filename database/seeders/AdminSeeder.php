<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Enums\UserRoleEnum;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email = 'admin@div-art.com';
        $admin = DB::table('users')->where('email', $email)->first();

        if (empty($admin)) {
            DB::table('users')->insert([
                'role' => UserRoleEnum::Admin,
                'company' => 'YelpHero',
                'name' => 'Admin',
                'email' => $email,
                'password' => Hash::make('123123123'),
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
