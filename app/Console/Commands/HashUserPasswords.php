<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HashUserPasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:hash-passwords';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hash user passwords that are not already hashed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Obtener todos los usuarios
        $users = DB::table('users')->get();

        foreach ($users as $user) {
            // Verificar si la contraseña ya está hasheada usando un patrón Bcrypt
            if (!preg_match('/^\$2y\$/', $user->password)) {
                // Si no está hasheada, entonces hashearla y actualizarla en la base de datos
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['password' => Hash::make($user->password)]);
            }
        }

        $this->info('User passwords hashed successfully.');
    }
}
