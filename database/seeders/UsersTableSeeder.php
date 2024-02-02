<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'username' => 'nathan',
                'password' => '$2y$12$VBbo3rSQo3iS.Jp31GoU1.x1cDHE0lBSWuKGrBuUURw8zNMDlkW86',
                'name' => 'nathan nadeak',
                'email' => 'nathan@gmail.com',
                'nip' => '1234567890',
                'unit' => 'IT',
                'image' => 'nathan_profile.jpg',
                'bio' => 'Saya suka gym',
                'role' => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'bryan',
                'password' => '$2y$12$VBbo3rSQo3iS.Jp31GoU1.x1cDHE0lBSWuKGrBuUURw8zNMDlkW86',
                'name' => 'bryan bonifasius',
                'email' => 'bryan@gmail.com',
                'nip' => '0987654321',
                'unit' => 'Marketing',
                'image' => 'bryan_profil.jpg',
                'bio' => 'Saya suka makan',
                'role' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'boy',
                'password' => '$2y$12$VBbo3rSQo3iS.Jp31GoU1.x1cDHE0lBSWuKGrBuUURw8zNMDlkW86',
                'name' => 'boy limbong',
                'email' => 'boy@gmail.com',
                'nip' => '1122334455',
                'unit' => 'Accountant',
                'image' => 'boy_profile.jpg',
                'bio' => 'Saya suka nonton film',
                'role' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
