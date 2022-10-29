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
        $user->address = "bac ninh";
        $user->dob = "2000-02-02";
        $user->role_id = UserRole::SYSTEM_ADMIN;
        $user->name = "amin";
        $user->email = "tuan@gmail.com";
        $user->password = Hash::make('12345678');
        $user->save();

    }
}
