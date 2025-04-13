<div>
    <div class="main">
        <div class="main-content project">
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="d-flex align-items-center mb-4">
                                <a href="{{ route('admin.location.store') }}"
                                    class="btn btn-primary d-inline-flex align-items-center ms-auto">
                                    <i class="bx bx-plus-circle me-2"></i> Tambah Lokasi
                                </a>
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
                                                    colspan="1" style="width: 150px;">Nama</th>
                                                <th class="border-bottom-0 sorting fs-14 font-w500 text-center"
                                                    tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="1" style="width: 250px;">Deskripsi</th>
                                                <th class="border-bottom-0 sorting_disabled fs-14 font-w500 text-center"
                                                    rowspan="1" colspan="1" style="width: 150px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($datas as $data)
                                                <tr class="odd">
                                                    <td class="sorting_1 text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-center">{{ $data->name }}</td>
                                                    <td class="text-center">{{ $data->description }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.location.edit', $data->id) }}"
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
                                </div>
                            @endif
                        </div>
                    </div>
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
                            <h3 id="modalLabel{{ $data->id }}">Hapus Lokasi</h3>
                            <p>Apakah Kamu Yakin Menghapus Lokasi {{ $data->name }}?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6 mb-0">
                                    <a href="javascript:void(0);" class="btn btn-danger continue-btn"
                                        wire:click="deleteLocation('{{ $data->id }}')" data-bs-dismiss="modal">
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
