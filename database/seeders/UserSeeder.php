<?php

namespace Database\Seeders;

use App\Entities\User\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $recordCount = 20;

        for ($i = 0; $i < $recordCount; $i++) {
            $data[] = [
                'name' => fake()->name(),
                'surname' => fake()->name(),
                'patronymic' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'gender' => rand(1,2),
                'age' => [rand(18,34), rand(18,34), rand(18,34), rand(34,84)][rand(0,3)],
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ];
        }

        User::insert([
            [
                'name' => 'Mezuno',
                'surname' => '',
                'patronymic' => '',
                'email' => 'mekishido@gmail.com',
                'email_verified_at' => now(),
                'gender' => rand(1,2),
                'age' => [rand(18,34), rand(18,34), rand(18,34), rand(34,84)][rand(0,3)],
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ], [
                'name' => 'Mezuno',
                'surname' => '',
                'patronymic' => '',
                'email' => 'mekishido2@gmail.com',
                'email_verified_at' => now(),
                'gender' => rand(1,2),
                'age' => [rand(18,34), rand(18,34), rand(18,34), rand(34,84)][rand(0,3)],
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ]
        ]);

        foreach (array_chunk($data, 1000) as $chunk) {
            User::insert($chunk);
        }
    }
}
