<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->company_id = 1;
        $user->role_type = "system_admin";
        $user->role_id = UserRole::SYSTEM_ADMIN;
        $user->name = "amin";
        $user->email = "admin@gmail.com";
        $user->password = Hash::make('12345678');
        $user->save();
    }
}
