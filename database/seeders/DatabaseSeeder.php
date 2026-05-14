<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'              => 'Admin Finedu',
            'email'             => 'admin@finedu.com',
            'password'          => Hash::make('finedu123'),
            'email_verified_at' => now(),
        ]);

        $this->call(CategoriaSeeder::class);
        $this->call(GastoSeeder::class);
    }
}