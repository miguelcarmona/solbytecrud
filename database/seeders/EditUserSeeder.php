        <?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EditUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar si ya existe un usuario administrador
        if (User::where('email', 'editar@solbyte')->exists()) {
            return;
        }

        // Crear el usuario administrador
        $adminUser = User::create([
            'name' => 'editar',
            'email' => 'editar@solbyte',
            'password' => Hash::make('contrasena'),
            'role' => 'editar',
        ]);

        // Asignar el rol de administrador
        $adminRole = Role::where('name', 'administrador')->first();
        if ($adminRole) {
            $adminUser->roles()->attach($adminRole->id);
        }
    }
}
