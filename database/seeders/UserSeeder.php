<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
                'password' => Hash::make(Str::password()),
            ]
        );

        User::firstOrCreate(
            [
                'email' => 'divulgacaosp1@hotmail.com',
            ],
            [
                'name' => 'Alexandre Souto',
                'password' => Hash::make(Str::password()),
            ]
        );

        User::firstOrCreate(
            [
                'email' => 'tiraosi@yahoo.com.br',
            ],
            [
                'name' => 'Adriana Oliveira',
                'password' => Hash::make(Str::password()),
            ]
        );
    }
}
