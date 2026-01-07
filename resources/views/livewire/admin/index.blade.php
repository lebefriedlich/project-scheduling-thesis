<div>
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-body">
                    <h5 class="mb-4 fw-bold">Seminar Proposal</h5>
                    <div class="table-responsive">
                        <table class="table table-vcenter text-nowrap table-bordered dataTable no-footer mw-100"
                            id="dataTable" role="grid">
                            <thead>
                                <tr class="top">
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1" style="width: 20px;">No.
                                    </th>
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1" style="width: 150px;">
                                        Nama Mahasiswa</th>
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1" style="width: 250px;">
                                        Tanggal Pelaksanaan</th>
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1" style="width: 250px;">
                                        Pukul</th>
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1" style="width: 250px;">
                                        Lokasi</th>
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1" style="width: 250px;">
                                        Ketua Penguji</th>
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1" style="width: 250px;">
                                        Penguji 1</th>
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1" style="width: 250px;">
                                        Penguji 2</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($sempro->isEmpty())
                                    <tr>
                                        <td colspan="8" class="text-center">Data Masih Kosong</td>
                                    </tr>
                                @endif
                                @foreach ($sempro as $data)
                                    <tr class="odd">
                                        <td class="sorting_1 text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $data->user->name }}</td>
                                        <td class="text-center">
                                            {{ Carbon\Carbon::parse($data->schedules[0]->schedule_date)->locale('id')->isoFormat('D MMMM YYYY') }}
                                        </td>
                                        <td class="text-center">
                                            {{ $data->schedules[0]->start_time . ' - ' . $data->schedules[0]->end_time }}
                                        </td>
                                        <td class="text-center">{{ $data->schedules[0]->location->name }}</td>
                                        <td class="text-center">
                                            {{ $data->schedules[0]->scheduleLecturers[0]->lecturer->name }}</td>
                                        <td class="text-center">
                                            {{ $data->schedules[0]->scheduleLecturers[1]->lecturer->name }}</td>
                                        <td class="text-center">
                                            {{ $data->schedules[0]->scheduleLecturers[2]->lecturer->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-body">
                    <h5 class="mb-4 fw-bold">Seminar Hasil</h5>
                    <div class="table-responsive">
                        <table class="table table-vcenter text-nowrap table-bordered dataTable no-footer mw-100"
                            id="dataTable" role="grid">
                            <thead>
                                <tr class="top">
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1" style="width: 20px;">No.
                                    </th>
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1" style="width: 150px;">
                                        Nama Mahasiswa</th>
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1" style="width: 250px;">
                                        Tanggal Pelaksanaan</th>
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1"
                                        style="width: 250px;">
                                        Pukul</th>
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1"
                                        style="width: 250px;">
                                        Lokasi</th>
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1"
                                        style="width: 250px;">
                                        Ketua Penguji</th>
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1"
                                        style="width: 250px;">
                                        Penguji 1</th>
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1"
                                        style="width: 250px;">
                                        Penguji 2</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($semhas->isEmpty())
                                    <tr>
                                        <td colspan="8" class="text-center">Data Masih Kosong</td>
                                    </tr>
                                @endif
                                @foreach ($semhas as $data)
                                    <tr class="odd">
                                        <td class="sorting_1 text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $data->sempro->user->name }}</td>
                                        <td class="text-center">
                                            {{ Carbon\Carbon::parse($data->schedules[0]->schedule_date)->locale('id')->isoFormat('D MMMM YYYY') }}
                                        </td>
                                        <td class="text-center">
                                            {{ $data->schedules[0]->start_time . ' - ' . $data->schedules[0]->end_time }}
                                        </td>
                                        <td class="text-center">{{ $data->schedules[0]->location->name }}</td>
                                        <td class="text-center">
                                            {{ $data->schedules[0]->scheduleLecturers[0]->lecturer->name }}</td>
                                        <td class="text-center">
                                            {{ $data->schedules[0]->scheduleLecturers[1]->lecturer->name }}</td>
                                        <td class="text-center">
                                            {{ $data->schedules[0]->scheduleLecturers[2]->lecturer->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-body">
                    <h5 class="mb-4 fw-bold">Sidang Skripsi</h5>
                    <div class="table-responsive">
                        <table class="table table-vcenter text-nowrap table-bordered dataTable no-footer mw-100"
                            id="dataTable" role="grid">
                            <thead>
                                <tr class="top">
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1"
                                        style="width: 20px;">No.
                                    </th>
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1"
                                        style="width: 150px;">
                                        Nama Mahasiswa</th>
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1"
                                        style="width: 250px;">
                                        Tanggal Pelaksanaan</th>
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1"
                                        style="width: 250px;">
                                        Pukul</th>
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1"
                                        style="width: 250px;">
                                        Lokasi</th>
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1"
                                        style="width: 250px;">
                                        Ketua Penguji</th>
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1"
                                        style="width: 250px;">
                                        Penguji 1</th>
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1"
                                        style="width: 250px;">
                                        Penguji 2</th>
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1"
                                        style="width: 250px;">
                                        Penguji 3</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($skripsi->isEmpty())
                                    <tr>
                                        <td colspan="9" class="text-center">Data Masih Kosong</td>
                                    </tr>
                                @endif
                                @foreach ($skripsi as $data)
                                    <tr class="odd">
                                        <td class="sorting_1 text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $data->semhas->sempro->user->name }}</td>
                                        <td class="text-center">
                                            {{ Carbon\Carbon::parse($data->schedules[0]->schedule_date)->locale('id')->isoFormat('D MMMM YYYY') }}
                                        </td>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($data->schedules[0]->start_time)->format('H:i') . ' - ' . \Carbon\Carbon::parse($data->schedules[0]->end_time)->format('H:i') }}
                                        </td>
                                        <td class="text-center">{{ $data->schedules[0]->location->name }}</td>
                                        <td class="text-center">
                                            {{ $data->schedules[0]->scheduleLecturers[0]->lecturer->name }}</td>
                                        <td class="text-center">
                                            {{ $data->schedules[0]->scheduleLecturers[1]->lecturer->name }}</td>
                                        <td class="text-center">
                                            {{ $data->schedules[0]->scheduleLecturers[2]->lecturer->name }}</td>
                                        <td class="text-center">
                                            {{ $data->schedules[0]->scheduleLecturers[3]->lecturer->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
