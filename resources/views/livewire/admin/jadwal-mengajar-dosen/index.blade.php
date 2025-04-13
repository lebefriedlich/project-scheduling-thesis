<div>
    <div class="main">
        <div class="main-content project">
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="d-flex align-items-center mb-4">
                                <!-- Button Trigger -->
                                <button type="button" class="btn btn-success ms-2" data-bs-toggle="modal"
                                    data-bs-target="#importModal">
                                    <i class="bx bx-upload me-2"></i> Import Excel
                                </button>

                                <!-- Modal Upload -->
                                <div wire:ignore.self class="modal fade" id="importModal" tabindex="-1"
                                    aria-labelledby="importModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form wire:submit.prevent="importExcel" enctype="multipart/form-data">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="importModalLabel">Import Jadwal Mengajar
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="fileExcel">Upload File Excel (.xlsx / .xls)</label>
                                                        <input type="file" class="form-control"
                                                            wire:model="fileExcel" accept=".xlsx,.xls">
                                                        @error('fileExcel')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Import</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @if ($datas->isEmpty())
                                <div class="text-center my-4">
                                    <strong>Data masih kosong</strong>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table
                                        class="table table-vcenter text-nowrap table-bordered dataTable no-footer mw-100"
                                        id="dataTable" role="grid">
                                        <thead>
                                            <tr class="top">
                                                <th class="border-bottom-0 sorting fs-14 font-w500 text-center"
                                                    tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="1" style="width: 20px;">No.</th>
                                                <th class="border-bottom-0 sorting fs-14 font-w500 text-center"
                                                    tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="1" style="width: 150px;">Hari</th>
                                                <th class="border-bottom-0 sorting fs-14 font-w500 text-center"
                                                    tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="1" style="width: 250px;">Pukul</th>
                                                <th class="border-bottom-0 sorting fs-14 font-w500 text-center"
                                                    tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="1" style="width: 250px;">Matakuliah</th>
                                                <th class="border-bottom-0 sorting fs-14 font-w500 text-center"
                                                    tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="1" style="width: 250px;">Dosen</th>
                                                <th class="border-bottom-0 sorting fs-14 font-w500 text-center"
                                                    tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="1" style="width: 250px;">Room</th>
                                                <th class="border-bottom-0 sorting fs-14 font-w500 text-center"
                                                    tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="1" style="width: 250px;">Kelas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($datas->isEmpty())
                                                <tr>
                                                    <td colspan="7" class="text-center">Data Masih Kosong</td>
                                                </tr>
                                            @endif
                                            @foreach ($datas as $data)
                                                <tr class="odd">
                                                    <td class="sorting_1 text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-center">{{ $data->day }}</td>
                                                    <td class="text-center">
                                                        {{ $data->start_time . ' - ' . $data->end_time }}</td>
                                                    <td class="text-center">{{ $data->course_name }}</td>
                                                    <td class="text-center">{{ $data->lecturer->name }}</td>
                                                    <td class="text-center">{{ $data->room }}</td>
                                                    <td class="text-center">{{ $data->class }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:loading>
        <x-loading />
    </div>

    @push('scripts')
        <script>         
            Livewire.on('tableUpdated', function() {
                $('#dataTable').DataTable().destroy();
                $('#dataTable').DataTable();
            });

            window.addEventListener('closeModal', () => {
                const modalEl = document.querySelector('.modal.show');
                if (modalEl) {
                    const modalInstance = bootstrap.Modal.getInstance(modalEl);
                    modalInstance.hide();
                }
            });
        </script>
    @endpush
</div>
