<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->insert([
            [
                'title' => 'Daily Scrum',
                'description' => 'Online, teams',
                'start_time' => '2024-02-08 14:00:00',
                'end_time' => '2024-02-06 14:30:00',
                'created_at' => '2024-01-29 12:33:17',
                'created_by' => 'nathan nadeak',
                'user_id' => '1',
            ],
            [
                'title' => 'Rapat Awal Bulan',
                'description' => 'Ruang Rapat A',
                'start_time' => '2024-02-08 07:00:00',
                'end_time' => '2024-02-07 09:00:00',
                'created_at' => '2024-01-30 11:46:29',
                'created_by' => 'bryan bonifasius',
                'user_id' => '2',
            ],
            [
                'title' => 'Laporan Harian',
                'description' => 'Ruang IT',
                'start_time' => '2024-02-08 15:45:00',
                'end_time' => '2024-02-07 17:45:00',
                'created_at' => '2024-01-30 11:46:29',
                'created_by' => 'bryan bonifasius',
                'user_id' => '2',
            ],
        ]);
    }
}
