<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user_data = [
            [
                'nip' => '1122334455',
                'nama' => 'Budi',
                'role' => 'Admin',
                'username' => 'budi',
                'password' => bcrypt('budi'),
            ],[
                'nip' => '5544332211',
                'nama' => 'Andi',
                'role' => 'Manajemen',
                'username' => 'andi',
                'password' => bcrypt('andi'),
            ]
        ];
        foreach($user_data as $data) {
            User::create($data);
        }
    }
}
