<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create([
            'id' => Role::ADMIN,
            'name'=> 'Administrador',
        ]);

        Role::create([
            'id' => Role::PARTNER,
            'name'=> 'Aliado',
        ]);

        Role::create([
            'id' => Role::AFFILIATE,
            'name'=> 'Afiliado',
        ]);

        User::factory()->create([
            'role_id' => Role::ADMIN,
            'name' => 'Admin',
            'email' => 'admin@shopcard.com',
            'password'  => bcrypt('123'),
            'email_verified_at' => now(),
        ]);

        User::factory()->create([
            'role_id' => Role::PARTNER,
            'name' => 'Aliado',
            'email' => 'aliado@shopcard.com',
            'password'  => bcrypt('123'),
            'email_verified_at' => now(),
        ]);

        User::factory()->create([
            'role_id' => Role::AFFILIATE,
            'name' => 'Afiliado',
            'email' => 'afiliado@shopcard.com',
            'password'  => bcrypt('123'),
            'email_verified_at' => now(),
        ]);

        



    }
}
