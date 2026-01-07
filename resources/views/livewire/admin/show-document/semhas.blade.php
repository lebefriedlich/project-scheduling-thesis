<div>
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-body">
                    <div
                        style="width: 100%; height: 600px; border: 1px solid #ccc; border-radius: 10px; overflow: hidden;">
                        <iframe src="{{ asset('storage/' . $datas->kompre) }}"
                            style="width: 100%; height: 100%; border: none;" allowfullscreen></iframe>
                    </div>
                    <div class="gr-btn mt-15">
                        <a href="{{ route('admin.submission.index') }}" class="btn btn-danger btn-lg mr-15 fs-16">Back</a>
                        <button data-bs-toggle="modal" data-bs-target="#rejectionModal"
                            class="btn btn-warning btn-lg mr-15 fs-16">
                            Tolak
                        </button>
                        <a href="{{ route('admin.acc-schedule.index', ['exam_id' => $datas->id, 'exam_type' => 'Semhas']) }}"
                            class="btn btn-primary btn-lg mr-15 fs-16">Atur Jadwal</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rejectionModal" tabindex="-1" aria-labelledby="rejectionModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="reject">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectionModalLabel">Alasan Penolakan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="reason" class="form-label">Masukkan alasan penolakan:</label>
                            <textarea wire:model.defer="rejectionReason" class="form-control" id="reason" rows="4" required></textarea>
                            @error('rejectionReason')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Kirim Penolakan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
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
