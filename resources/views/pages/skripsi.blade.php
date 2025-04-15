<x-layouts.layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="container-fluid py-4">
        <div class="card w-100">
            <div class="card-body p-3">
                @if (!$periode)
                    <h3 class="text-center">Periode Belum Dibuka</h3>
                @elseif ($periode->quota == 0)
                    <h3 class="text-center">Kuota Sidang Skripsi Sudah Penuh</h3>
                @elseif ($sempro->semhas->skripsi->is_submit ?? false)
                    <h3 class="text-center">Anda Telah Mengajukan Sidang Skripsi</h3>
                @else
                    <h4 class="text-uppercase">Ajukan Jadwal Sidang Skripsi</h4>

                    <form action="{{ route('user.skripsi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- @dd($sempro) --}}
                        <div class="row">
                            <div class="form-group">
                                <label class="form-control-label">Upload Dokumen Sidang Skripsi</label>
                                <input type="file" class="form-control" name="doc_skripsi" id="pdfInput"
                                    accept="application/pdf">
                            </div>

                            {{-- PDF Preview --}}
                            <div class="form-group mt-3" id="pdfPreviewContainer"
                                style="{{ $sempro->semhas->skripsi && $sempro->semhas->skripsi->doc_skripsi ? '' : 'display: none;' }}">
                                <label class="form-control-label">Preview File</label>
                                <embed id="pdfPreview"
                                    src="{{ $sempro->semhas->skripsi && $sempro->semhas->skripsi->doc_skripsi ? asset('storage/' . $sempro->semhas->skripsi->doc_skripsi) : '' }}"
                                    type="application/pdf" width="100%" height="500px" />
                            </div>

                            <script>
                                document.getElementById('pdfInput').addEventListener('change', function(event) {
                                    const file = event.target.files[0];

                                    if (file && file.type === 'application/pdf') {
                                        const embed = document.getElementById('pdfPreview');
                                        embed.src = URL.createObjectURL(file);

                                        const container = document.getElementById('pdfPreviewContainer');
                                        container.style.display = 'block';
                                    } else {
                                        alert('Mohon unggah file PDF.');
                                    }
                                });
                            </script>
                            <div class="d-flex align-items-center"
                                style="height: 15px; position: relative; margin-top: 20px;">
                                <button type="submit" name="is_submit" value="false"
                                    class="btn btn-primary btn-sm me-2">Draft</button>
                                <button type="submit" name="is_submit" value="true"
                                    class="btn btn-primary btn-sm">Submit</button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layouts.layout>
