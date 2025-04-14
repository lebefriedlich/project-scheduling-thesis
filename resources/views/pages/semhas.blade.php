<x-layouts.layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="container-fluid py-4">
        <div class="card w-100">
            <div class="card-body p-3">
                @if ($isActiveForm)
                    <h3 class="text-center">Anda Belum Seminar Proposal</h3>
                    
                @endif
                <h4 class="text-uppercase">Ajukan Jadwal Semhas</h4>
                <div class="row">
                    <div class="form-group">
                        <label class="form-control-label">Upload Dokumen Komprehensif</label>
                        <input type="file" class="form-control" name="kompre" id="pdfInput" accept="application/pdf">
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
                    <div class="d-flex align-items-center" style="height: 15px; position: relative; margin-top: 20px;">
                        <button class="btn btn-primary btn-sm me-2">Draft</button>
                        <button class="btn btn-primary btn-sm">Submit</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
</x-layouts.layout>
