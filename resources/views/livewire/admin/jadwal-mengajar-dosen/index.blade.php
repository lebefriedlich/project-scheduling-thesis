<div>
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-body">
                    <div class="row align-items-center mb-5">
                        @if ($datas->isEmpty() && !$is_search)
                            <div class="col d-flex justify-content-start">
                                <button type="button" class="btn btn-success ms-2" data-bs-toggle="modal"
                                    data-bs-target="#importModal">
                                    <i class="bx bx-upload me-2"></i> Import Excel
                                </button>
                            </div>
                        @endif
                        @if (!$datas->isEmpty() || $is_search)
                            <div class="col d-flex justify-content-start">
                                <button type="button" class="btn btn-danger ms-2" data-bs-toggle="modal"
                                    data-bs-target="#hapusModal">
                                    <i class="bx bx-trash me-2"></i> Hapus Data Jadwal Mengajar
                                </button>
                            </div>
                            <div class="col d-flex justify-content-end">
                                <input type="text" class="form-control w-auto" placeholder="Cari..."
                                    wire:model.live.debounce.300ms="search">
                            </div>
                        @endif
                    </div>

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
                                            <input type="file" class="form-control" wire:model="fileExcel"
                                                accept=".xlsx,.xls">
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
                    <div wire:ignore.self class="modal fade" id="hapusModal" tabindex="-1"
                        aria-labelledby="hapusModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form wire:submit.prevent="deleteAll">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="hapusModalLabel">Hapus Semua Data Jadwal Mengajar
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <p>Apakah Anda yakin ingin menghapus semua data jadwal mengajar?</p>
                                        <p>Data yang dihapus tidak dapat dikembalikan.</p>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @if ($datas->isEmpty() && $search)
                        <div class="text-center my-4">
                            <strong>Data tidak ditemukan</strong>
                        </div>
                    @elseif ($datas->isEmpty())
                        <div class="text-center my-4">
                            <strong>Data masih kosong</strong>
                        </div>
                    @else
                        <div class="table-responsive mt-5">
                            <table class="table table-vcenter text-nowrap table-bordered dataTable no-footer mw-100"
                                id="dataTable" role="grid">
                                <thead>
                                    <tr class="top">
                                        <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                            aria-controls="dataTable" rowspan="1" colspan="1"
                                            style="width: 20px;">No.</th>
                                        <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                            aria-controls="dataTable" rowspan="1" colspan="1"
                                            style="width: 150px;">Hari</th>
                                        <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                            aria-controls="dataTable" rowspan="1" colspan="1"
                                            style="width: 250px;">Pukul</th>
                                        <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                            aria-controls="dataTable" rowspan="1" colspan="1"
                                            style="width: 250px;">Matakuliah</th>
                                        <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                            aria-controls="dataTable" rowspan="1" colspan="1"
                                            style="width: 250px;">Dosen</th>
                                        <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                            aria-controls="dataTable" rowspan="1" colspan="1"
                                            style="width: 250px;">Room</th>
                                        <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                            aria-controls="dataTable" rowspan="1" colspan="1"
                                            style="width: 250px;">Kelas</th>
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
                            <nav aria-label="page navigation" class="d-flex justify-content-end my-3 mx-5">
                                @if (!empty($datas))
                                    {{ $datas->links('pagination::bootstrap-4') }}
                                @endif
                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </div>
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

    @push('styles')
        <style>
            /* Dark mode styling for modals */
            body.dark .modal-content {
                background-color: #252837;
                color: #fff;
            }

            body.dark .modal-header {
                border-bottom-color: #222028;
            }

            body.dark .modal-footer {
                border-top-color: #222028;
            }

            body.dark .modal-body {
                color: #fff;
            }

            body.dark .modal-title {
                color: #fff;
            }

            body.dark .form-control {
                background-color: #1e1d2b;
                border-color: #222028;
                color: #fff;
            }

            body.dark .form-control:focus {
                background-color: #1e1d2b;
                border-color: #3c21f7;
                color: #fff;
            }

            body.dark .form-label,
            body.dark label {
                color: #fff;
            }

            body.dark .btn-close {
                filter: invert(1) grayscale(100%) brightness(200%);
            }
        </style>
    @endpush
</div>
