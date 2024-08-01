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
                'password' => 'budi',
            ],[
                'nip' => '2233445566',
                'nama' => 'Wati',
                'role' => 'Ketua',
                'username' => 'wati',
                'password' => 'wati',
            ],[
                'nip' => '3344556677',
                'nama' => 'Arie',
                'role' => 'Anggota',
                'username' => 'arie',
                'password' => 'arie',
            ] 
        ];
        foreach($user_data as $data) {
            User::create($data);
        }
    }
}
