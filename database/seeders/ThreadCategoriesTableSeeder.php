<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThreadCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('thread_categories')->delete();

        DB::statement('ALTER TABLE thread_categories AUTO_INCREMENT = 1');

        DB::table('thread_categories')->insert([
            ['category' => 'Book'],
            ['category' => 'Life'],
            ['category' => 'Sports'],
            ['category' => 'Food'],
            ['category' => 'Music'],
            ['category' => 'Movie'],
            ['category' => 'Game'],
            ['category' => 'Programming'],
            ['category' => 'Others'],
        ]);
    }
}
