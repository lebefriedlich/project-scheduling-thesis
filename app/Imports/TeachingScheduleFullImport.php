<?php

namespace App\Imports;

use App\Models\Lecturer;
use App\Models\TeachingSchedule;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TeachingScheduleFullImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $lecturerCache = [];

        foreach ($rows as $row) {
            // Lewatkan baris kosong atau kolom wajib kosong
            if (
                empty($row['hari']) ||
                empty($row['pukul']) ||
                empty($row['matakuliah']) ||
                empty($row['dosen'])
            ) {
                continue;
            }

            $dosenName = trim($row['dosen']);

            if (!isset($lecturerCache[$dosenName])) {
                $lecturerCache[$dosenName] = Lecturer::firstOrCreate(['name' => $dosenName]);
            }

            $lecturer = $lecturerCache[$dosenName];

            // Pecah waktu
            $jam = explode('-', $row['pukul']);
            $start = isset($jam[0]) ? trim($jam[0]) : null;
            $end = isset($jam[1]) ? trim($jam[1]) : null;

            TeachingSchedule::create([
                'lecturer_id' => $lecturer->id,
                'day' => $row['hari'],
                'start_time' => $start,
                'end_time' => $end,
                'course_name' => $row['matakuliah'],
                'room' => $row['ruang'],
                'class' => $row['kelas'],
            ]);
        }
    }
}
