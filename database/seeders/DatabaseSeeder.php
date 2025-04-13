<?php

namespace Database\Seeders;

use App\Models\Lecturer;
use App\Models\Location;
use App\Models\Periode;
use App\Models\Sempro;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'google_id' => '112445890483411176092',
            'nim' => '1',
            'name' => 'Admin Teknik Informatika',
            // siapa tau butuh avatar
            // 'avatar' => 'https://lh3.googleusercontent.com/a/ACg8ocJ5AXsAQxCuhDbqK-F6cwYpbn07bJUDdrcU3I3kT534fFPBmA=s96-c',
            'email' => 'teknikinformatika.uinmalang@gmail.com',
            'number_phone' => null,
            'is_admin' => true,
        ]);

        DB::table('users')->insert([
            'id' => 'f2b8c0a2-4d1e-4f3b-9f5c-6a7d8e5f3b2d',
            'google_id' => '106985701357580562082',
            'nim' => '220605110149',
            'name' => 'Maulana Haekal Noval Akbar',
            'email' => '220605110149@student.uin-malang.ac.id',
            'number_phone' => null,
            'is_admin' => false,
        ]);

        $datas_periode = [
            [
                'name' => 'Seminar Proposal 1',
                'description' => 'Seminar Proposal 1',
                'type' => 'sempro',
                'end_registration' => '2025-02-07',
                'start_schedule' => '2025-02-17',
                'end_schedule' => '2025-03-21',
                'quota' => 40,
            ],
            [
                'name' => 'Seminar Proposal 2',
                'description' => 'Seminar Proposal 2',
                'type' => 'sempro',
                'end_registration' => '2025-03-21',
                'start_schedule' => '2025-04-14',
                'end_schedule' => '2025-04-25',
                'quota' => 40,
            ],
            [
                'name' => 'Seminar Proposal 3',
                'description' => 'Seminar Proposal 3',
                'type' => 'sempro',
                'end_registration' => '2025-05-09',
                'start_schedule' => '2025-05-14',
                'end_schedule' => '2025-05-20',
                'quota' => 20,
            ],
            [
                'name' => 'Seminar Hasil 1',
                'description' => 'Seminar Hasil 1',
                'type' => 'semhas',
                'end_registration' => '2025-02-25',
                'start_schedule' => '2025-03-03',
                'end_schedule' => '2025-03-07',
                'quota' => 20,
            ],
            [
                'name' => 'Seminar Hasil 2',
                'description' => 'Seminar Hasil 2',
                'type' => 'semhas',
                'end_registration' => '2025-04-15',
                'start_schedule' => '2025-04-21',
                'end_schedule' => '2025-04-25',
                'quota' => 40,
            ],
            [
                'name' => 'Seminar Hasil 3',
                'description' => 'Seminar Hasil 3',
                'type' => 'semhas',
                'end_registration' => '2025-05-16',
                'start_schedule' => '2025-05-21',
                'end_schedule' => '2025-05-28',
                'quota' => 40,
            ],
            [
                'name' => 'Sidang Skripsi 1',
                'description' => 'Sidang Skripsi 1',
                'type' => 'skripsi',
                'end_registration' => '2025-04-17',
                'start_schedule' => '2025-04-28',
                'end_schedule' => '2025-04-30',
                'quota' => 20,
            ],
            [
                'name' => 'Sidang Skripsi 2',
                'description' => 'Sidang Skripsi 2',
                'type' => 'skripsi',
                'end_registration' => '2025-05-02',
                'start_schedule' => '2025-05-05',
                'end_schedule' => '2025-05-09',
                'quota' => 40,
            ],
            [
                'name' => 'Sidang Skripsi 3',
                'description' => 'Sidang Skripsi 3',
                'type' => 'skripsi',
                'end_registration' => '2025-06-05',
                'start_schedule' => '2025-06-11',
                'end_schedule' => '2025-06-20',
                'quota' => 40,
            ],
        ];

        foreach ($datas_periode as $data) {
            Periode::create($data);
        }

        Location::create([
            'name' => 'Ruang Sidang',
            'description' => 'Ruang Sidang',
        ]);

        Location::create([
            'name' => 'Ruang Baca',
            'description' => 'Ruang Baca',
        ]);
    }
}
