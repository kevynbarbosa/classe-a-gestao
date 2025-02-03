<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::firstOrCreate(
            [
                'email' => 'kevynbarbosa1@gmail.com',
            ],
            [
                'name' => 'Kevyn Barbosa',
                'password' => Hash::make('password'),
            ]
        );

        User::firstOrCreate(
            [
                'email' => 'divulgacaosp1@hotmail.com',
            ],
            [
                'name' => 'Alexandre Souto',
                'password' => Hash::make('password'),
            ]
        );

        User::firstOrCreate(
            [
                'email' => 'tiraosi@yahoo.com',
            ],
            [
                'name' => 'Adriana Oliveira',
                'password' => Hash::make('password'),
            ]
        );
    }
}
