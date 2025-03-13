<?php

namespace Database\Seeders;

use App\Models\Lecture;
use App\Models\Periode;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

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

        $faker = Faker::create();

        $datas_lecturer = [
            [
                'nip' => '123456789012345678',
                'name' => $faker->name(),
            ],
            [
                'nip' => '123456789012345679',
                'name' => $faker->name(),
            ],
            [
                'nip' => '123456789012345680',
                'name' => $faker->name(),
            ],
            [
                'nip' => '123456789012345681',
                'name' => $faker->name(),
            ],
            [
                'nip' => '123456789012345682',
                'name' => $faker->name(),
            ],
            [
                'nip' => '123456789012345683',
                'name' => $faker->name(),
            ]
        ];

        foreach ($datas_lecturer as $data) {
            Lecture::create($data);
        }

        $datas_periode = [
            [
                'name' => 'Seminar Proposal 1',
                'description' => 'Seminar Proposal 1',
                'type' => 'sempro',
                'start_schedule' => '2025-02-01',
                'end_schedule' => '2025-03-31',
                'quota' => 20,
            ],
            [
                'name' => 'Seminar Proposal 2',
                'description' => 'Seminar Proposal 2',
                'type' => 'sempro',
                'start_schedule' => '2025-04-01',
                'end_schedule' => '2025-05-31',
                'quota' => 20,
            ],
            [
                'name' => 'Seminar Proposal 3',
                'description' => 'Seminar Proposal 3',
                'type' => 'sempro',
                'start_schedule' => '2025-06-01',
                'end_schedule' => '2025-07-31',
                'quota' => 20,
            ],
            [
                'name' => 'Seminar Hasil 1',
                'description' => 'Seminar Hasil 1',
                'type' => 'semhas',
                'start_schedule' => '2025-02-01',
                'end_schedule' => '2025-03-31',
                'quota' => 20,
            ],
            [
                'name' => 'Seminar Hasil 2',
                'description' => 'Seminar Hasil 2',
                'type' => 'semhas',
                'start_schedule' => '2025-04-01',
                'end_schedule' => '2025-05-31',
                'quota' => 20,
            ],
            [
                'name' => 'Seminar Hasil 3',
                'description' => 'Seminar Hasil 3',
                'type' => 'semhas',
                'start_schedule' => '2025-06-01',
                'end_schedule' => '2025-07-31',
                'quota' => 20,
            ],
            [
                'name' => 'Sidang Skripsi 1',
                'description' => 'Sidang Skripsi 1',
                'type' => 'skripsi',
                'start_schedule' => '2025-02-01',
                'end_schedule' => '2025-03-31',
                'quota' => 20,
            ],
            [
                'name' => 'Sidang Skripsi 2',
                'description' => 'Sidang Skripsi 2',
                'type' => 'skripsi',
                'start_schedule' => '2025-04-01',
                'end_schedule' => '2025-05-31',
                'quota' => 20,
            ],
            [
                'name' => 'Sidang Skripsi 3',
                'description' => 'Sidang Skripsi 3',
                'type' => 'skripsi',
                'start_schedule' => '2025-06-01',
                'end_schedule' => '2025-07-31',
                'quota' => 20,
            ],
        ];

        foreach ($datas_periode as $data) {
            Periode::create($data);
        }
    }
}
