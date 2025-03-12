<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user= new User();
        $user->name="Member1";
        $user->email="member@piopio.com";
        $user->password=Hash::make("secret");

        $role_member = Role::where('name', 'member')->first();
        $user->save();
        $user->roles()->attach($role_member);

        $user = new User();
        $user->name = "Admin1";
        $user->email = "Admin@piopio.com";
        $user->password = Hash::make("secret");

        $role_admin = Role::where('name', 'admin')->first();
        $user->save();
        $user->roles()->attach($role_admin);


        
    }
}
