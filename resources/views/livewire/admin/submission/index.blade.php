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
                                        Periode</th>
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1" style="width: 250px;">
                                        Pembimbing 1</th>
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1" style="width: 250px;">
                                        Pembimbing 2</th>
                                    <th class="border-bottom-0 sorting_disabled fs-14 font-w500 text-center"
                                        rowspan="1" colspan="1" style="width: 150px;">Lihat Dokumen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($sempro->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center">Data Masih Kosong</td>
                                    </tr>
                                @endif
                                @foreach ($sempro as $data)
                                    <tr class="odd">
                                        <td class="sorting_1 text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $data->user->name }}</td>
                                        <td class="text-center">{{ $data->periode->name }}</td>
                                        <td class="text-center">{{ $data->mentor->name }}</td>
                                        <td class="text-center">{{ $data->secondMentor->name }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.show-document.sempro', $data->id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="bx bx-show me-1"></i> Lihat
                                            </a>
                                        </td>
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
                                        Periode</th>
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1" style="width: 250px;">
                                        Pembimbing 1</th>
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1" style="width: 250px;">
                                        Pembimbing 2</th>
                                    <th class="border-bottom-0 sorting_disabled fs-14 font-w500 text-center"
                                        rowspan="1" colspan="1" style="width: 150px;">Lihat Dokumen
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($semhas->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center">Data Masih Kosong</td>
                                    </tr>
                                @endif
                                @foreach ($semhas as $data)
                                    <tr class="odd">
                                        <td class="sorting_1 text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $data->sempro->user->name }}</td>
                                        <td class="text-center">{{ $data->periode->name }}</td>
                                        <td class="text-center">{{ $data->sempro->mentor->name }}</td>
                                        <td class="text-center">{{ $data->sempro->secondMentor->name }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.show-document.semhas', $data->id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="bx bx-show me-1"></i> Lihat
                                            </a>
                                        </td>
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
                                        style="width: 20px;">No.</th>
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1"
                                        style="width: 150px;">Nama Mahasiswa</th>
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1"
                                        style="width: 250px;">Periode</th>
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1"
                                        style="width: 250px;">Pembimbing 1</th>
                                    <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                        aria-controls="dataTable" rowspan="1" colspan="1"
                                        style="width: 250px;">Pembimbing 2</th>
                                    <th class="border-bottom-0 sorting_disabled fs-14 font-w500 text-center"
                                        rowspan="1" colspan="1" style="width: 150px;">Lihat Dokumen
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($skripsi->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center">Data Masih Kosong</td>
                                    </tr>
                                @endif
                                @foreach ($skripsi as $data)
                                    <tr class="odd">
                                        <td class="sorting_1 text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $data->semhas->sempro->user->name }}</td>
                                        <td class="text-center">{{ $data->periode->name }}</td>
                                        <td class="text-center">{{ $data->semhas->sempro->mentor->name }}</td>
                                        <td class="text-center">
                                            {{ $data->semhas->sempro->secondMentor->name }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.show-document.skripsi', $data->id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="bx bx-show me-1"></i> Lihat
                                            </a>
                                        </td>
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
