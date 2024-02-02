<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RolesTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'anggota'],
            ['id' => 2, 'name' => 'pengurus'],
            ['id' => 3, 'name' => 'admin'],
        ]);
    }
}
