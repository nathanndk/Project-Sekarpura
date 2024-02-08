<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            ForumTypesTableSeeder::class,
            ThreadCategoriesTableSeeder::class,
            RolesTablesSeeder::class,
            EventsTableSeeder::class,
            // NotificationsTableSeeder::class,
        ]);
    }
}
