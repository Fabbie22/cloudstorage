<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        $faker = Faker::create();
    
        // Fetch all valid role IDs from the 'roles' table
        $roleIds = DB::table('roles')->pluck('id')->toArray();

        
        // Loop 100 times to create 100 fake users
        for ($i = 0; $i < 100; $i++) {
            DB::table('users')->insert([
                'name' => $faker->userName(),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'role_id' => 2, // Assign a valid role_id
            ]);
        }
    }
    }
