<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('notifications')->insert([
            [
                'ref_id' => 1,
                'modules' => 'threads',
                'keterangan' => 'Nathan request thread "Kerja di angkasa Pura 2 sangat indah"',
                'isRead' => false,
                'created_at' => now(),
                'updated_at' => now(),
                'user_id' => 1,
            ],
            [
                'ref_id' => 2,
                'modules' => 'comments',
                'keterangan' => 'Bryan memberikan komentar pada thread "Kerja di angkasa Pura 2 sangat indah"',
                'isRead' => false,
                'created_at' => now(),
                'updated_at' => now(),
                'user_id' => 2,
            ],
            [
                'ref_id' => 3,
                'modules' => 'comments',
                'keterangan' => 'Boy memberikan komentar pada thread "Kerja di angkasa Pura 2 sangat indah"',
                'isRead' => false,
                'created_at' => now(),
                'updated_at' => now(),
                'user_id' => 1,
            ],
        ]);
    }
}
