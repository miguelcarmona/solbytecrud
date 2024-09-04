<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar si ya existe un usuario ver
        if (User::where('email', 'ver@solbyte')->exists()) {
            return;
        }

        // Crear el usuario editar
        $adminUser = User::create([
            'name' => 'ver',
            'email' => 'ver@solbyte',
            'password' => Hash::make('contrasena'),
            'role' => 'ver',
        ]);
        
        
        // Verificar si ya existe un usuario editar
        if (User::where('email', 'editar@solbyte')->exists()) {
            return;
        }

        // Crear el usuario editar
        $adminUser = User::create([
            'name' => 'editar',
            'email' => 'editar@solbyte',
            'password' => Hash::make('contrasena'),
            'role' => 'editar',
        ]);
    }
}
