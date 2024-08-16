<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user_data = [
            'nip' => '1122334455',
            'nama' => 'Budi',
            'role' => 'Admin',
            'username' => 'budi',
            'password' => bcrypt('budi'),
        ];
        
        User::create($user_data);
    }
}
