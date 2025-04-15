<x-layouts.layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container-fluid py-4">
        <div class="card w-100">
            <div class="card-body p-3">
                @if ($periode == null)
                    <h3 class="text-center">Periode Belum Dibuka</h3>
                @elseif ($periode->quota == 0)
                    <h3 class="text-center">Kuota Seminar Proposal Sudah Penuh</h3>
                @elseif ($sempro->is_submit ?? false)
                    <h3 class="text-center">Anda Telah Mengajukan Seminar Proposal</h3>
                @else
                    <h4 class="text-uppercase">Ajukan Jadwal Seminal Proposal</h4>

                    <form action="{{ route('user.sempro.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- @dd($sempro) --}}
                        <div class="row">
                            {{-- <div class="col-md-12">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Nama</label>
                                <input class="form-control" type="text" name="name" value="{{ $sempro->name }}"
                                    placeholder="Nama Lengkap">
                            </div>
                        </div> --}}

                            <input class="form-control" type="text" name="periode_id" value="{{ $periode->id }}"
                                hidden>

                            <div class="form-group">
                                <label class="form-control-label">Dosen Pembimbing</label>
                                <select class="form-control" name="mentor_id" id="mentor_id">
                                    <option disabled {{ old('mentor_id', $sempro->mentor_id ?? '') ? '' : 'selected' }}>
                                        Pilih Dosen Pembimbing</option>
                                    @foreach ($lecturer as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('mentor_id', $sempro->mentor_id ?? '') == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-control-label">Dosen Pembimbing Kedua</label>
                                <select class="form-control" name="second_mentor_id" id="second_mentor_id">
                                    <option disabled
                                        {{ old('second_mentor_id', $sempro->second_mentor_id ?? '') ? '' : 'selected' }}>
                                        Pilih Dosen Pembimbing</option>
                                    @foreach ($lecturer as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('second_mentor_id', $sempro->second_mentor_id ?? '') == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-control-label">Upload Dokumen Pra Proposal</label>
                                <input type="file" class="form-control" name="doc_pra_proposal" id="pdfInput"
                                    accept="application/pdf">
                            </div>

                            {{-- PDF Preview --}}
                            <div class="form-group mt-3" id="pdfPreviewContainer"
                                style="{{ $sempro && $sempro->doc_pra_proposal ? '' : 'display: none;' }}">
                                <label class="form-control-label">Preview File</label>
                                <embed id="pdfPreview"
                                    src="{{ $sempro && $sempro->doc_pra_proposal ? asset('storage/' . $sempro->doc_pra_proposal) : '' }}"
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
</x-layouts.layout>
