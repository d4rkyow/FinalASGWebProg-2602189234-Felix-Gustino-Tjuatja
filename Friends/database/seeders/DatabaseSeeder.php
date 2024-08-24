<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create('en_EN');
        $hobbiesList = ['badminton', 'game', 'run', 'basketball', 'drawing'];
        // Seed 20 users
        for ($i = 0; $i < 20; $i++) {
            DB::table('users')->insert([
                'name' => $faker->firstname(),
                'email' => $faker->email(),
                'password' => Hash::make('123456789'),
                'gender' => $faker->randomElement(['Male', 'Female']),
                'hobbies' => json_encode($faker->randomElements($hobbiesList, 3)), // 3 random hobbies
                'instagram_username' => 'https://www.instagram.com/felix_darkyow',
                'mobile_number' => $faker->phoneNumber(),
                'has_paid' => 1,
                'register_price' => rand(100000, 125000),
                'coins' => 100,
                'profile_path' => 'profile_img/' . $faker->numberBetween(1, 4) . '.jpg',
                 'visible' => true,
            ]);
        }

        // Insert specific users
        DB::table('users')->insert([
            'name' => "kevin",
            'email' => "kevin@gmail.com",
            'password' => Hash::make('kevin123'),
            'gender' => 'Male',
            'hobbies' => json_encode(['badminton', 'game', 'run']),
            'instagram_username' => 'https://www.instagram.com/felix_darkyow',
            'mobile_number' => $faker->phoneNumber(),
            'has_paid' => 1,
            'register_price' => rand(100000, 125000),
            'coins' => 100,
            'profile_path' => 'profile_img/' . $faker->numberBetween(1, 4) . '.jpg',
            'visible' => true,
        ]);

        DB::table('users')->insert([
            'name' => "felix",
            'email' => "felix@gmail.com",
            'password' => Hash::make('felix123'),
            'gender' => 'Male',
            'hobbies' => json_encode(['badminton', 'game', 'drawing']),
            'instagram_username' => 'https://www.instagram.com/felix_darkyow',
            'mobile_number' => $faker->phoneNumber(),
            'has_paid' => 1,
            'register_price' => rand(100000, 125000),
            'coins' => 100,
            'profile_path' => 'profile_img/' . $faker->numberBetween(1, 4) . '.jpg',
             'visible' => true,
        ]);

        // Seed friend_requests
        for ($i = 0; $i < 20; $i++) {
            DB::table('friend_requests')->insert([
                'sender_id' => $faker->numberBetween(1, 20),
                'receiver_id' => $faker->numberBetween(1, 20)
            ]);
        }

        // Seed friends
        for ($i = 0; $i < 20; $i++) {
            DB::table('friends')->insert([
                'user_id' => $faker->numberBetween(1, 20),
                'friend_id' => $faker->numberBetween(1, 20)
            ]);
        }
    }
}
