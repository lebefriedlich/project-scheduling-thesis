<x-layouts.layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="container-fluid py-4">
        <div class="card w-100">
            <div class="card-body p-3">

                {{-- @dd($semhas->is_submit); --}}
                @if ($isActiveForm)
                    <h3 class="text-center">Anda Belum Seminar Hasil</h3>
                @elseif ($periode == null)
                    <h3 class="text-center">Periode Belum Dibuka</h3>
                @elseif ($periode->quota == 0)
                    <h3 class="text-center">Kuota Seminar Hasil Sudah Penuh</h3>
                @elseif ($semhas->is_submit ?? false)
                    <h3 class="text-center">Anda Telah Mengajukan Seminar Hasil</h3>
                @else
                    <h4 class="text-uppercase">Ajukan Jadwal Seminal Hasil</h4>

                    <form action="{{ route('user.semhas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- @dd($sempro) --}}
                        <div class="row">
                            <div class="form-group">
                                <label class="form-control-label">Upload Dokumen Komprehensif</label>
                                <input type="file" class="form-control" name="kompre" id="pdfInput"
                                    accept="application/pdf">
                            </div>

                            {{-- PDF Preview --}}
                            <div class="form-group mt-3" id="pdfPreviewContainer"
                                style="{{ $semhas && $semhas->kompre ? '' : 'display: none;' }}">
                                <label class="form-control-label">Preview File</label>
                                <embed id="pdfPreview"
                                    src="{{ $semhas && $semhas->kompre ? asset('storage/' . $semhas->kompre) : '' }}"
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
