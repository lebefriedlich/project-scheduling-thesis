<div>
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-body">
                    <div class="d-flex align-items-center mb-4">
                        <a href="{{ route('admin.lecturer.store') }}"
                            class="btn btn-primary d-inline-flex align-items-center ms-auto">
                            <i class="bx bx-plus-circle me-2"></i> Tambah Data Dosen
                        </a>
                    </div>
                    @if (!$datas->isEmpty())
                        <div class="d-flex align-items-center mb-4">
                            <div class="col d-flex justify-content-end">
                                <input type="text" class="form-control w-auto" placeholder="Cari..."
                                    wire:model.live.debounce.300ms="search">
                            </div>
                        </div>
                    @endif
                    @if ($datas->isEmpty())
                        <div class="text-center my-4">
                            <strong>Data masih kosong</strong>
                        </div>
                    @else
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
                                            style="width: 150px;">NIP</th>
                                        <th class="border-bottom-0 sorting fs-14 font-w500 text-center" tabindex="0"
                                            aria-controls="dataTable" rowspan="1" colspan="1"
                                            style="width: 250px;">Nama</th>
                                        <th class="border-bottom-0 sorting_disabled fs-14 font-w500 text-center"
                                            rowspan="1" colspan="1" style="width: 150px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($datas->isEmpty())
                                        <tr>
                                            <td colspan="4" class="text-center">Data Masih Kosong</td>
                                        </tr>
                                    @endif
                                    @foreach ($datas as $data)
                                        <tr class="odd">
                                            <td class="sorting_1 text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">
                                                @if ($data->nip)
                                                    {{ $data->nip }}
                                                @else
                                                    <span class="text-muted">NIP belum diisi</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $data->name }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.lecturer.edit', $data->id) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $data->id }}">
                                                    <i class="bx bx-trash me-1"></i> Hapus
                                                </button>
                                            </td>
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

    @foreach ($datas as $data)
        <div class="modal fade" id="deleteModal{{ $data->id }}" tabindex="-1"
            aria-labelledby="modalLabel{{ $data->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3 id="modalLabel{{ $data->id }}">Hapus Data Dosen</h3>
                            <p>Apakah Kamu Yakin Menghapus Data Dosen {{ $data->name }}?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6 mb-0">
                                    <a href="javascript:void(0);" class="btn btn-danger continue-btn"
                                        wire:click="deleteLecturer('{{ $data->id }}')" data-bs-dismiss="modal">
                                        Hapus
                                    </a>
                                </div>
                                <div class="col-6 mb-0">
                                    <a href="javascript:void(0);" class="btn btn-primary cancel-btn"
                                        data-bs-dismiss="modal">Batal</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div wire:loading>
        <x-loading />
    </div>
</div>
