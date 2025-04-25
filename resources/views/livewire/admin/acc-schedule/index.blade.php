<div>
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 mb-24">
                            <div class="form-group">
                                <label class="form-label">Lokasi</label>
                                <select class="form-control custom-select select2" wire:model="location">
                                    <option value="">Pilih Lokasi</option>
                                    @foreach ($locations as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('location')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group" wire:ignore>
                                <label for="schedule_date" class="form-label">Tanggal Pelaksanaan</label>
                                <input type="text" id="schedule_date_input" class="form-control" autocomplete="off">
                            </div>

                            <input type="hidden" id="schedule_date_hidden" wire:model="schedule_date">
                            @error('schedule_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12 mb-24">
                            <div class="form-group">
                                <label class="form-label">Mulai Ujian</label>
                                <input type="time" wire:model="start_time" class="form-control">
                                @error('start_time')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 mb-24">
                            <div class="form-group">
                                <label class="form-label">Selesai Ujian</label>
                                <input type="time" wire:model="end_time" class="form-control">
                                @error('end_time')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    @if ($exam == 'Sempro' || $exam == 'Semhas')
                        <div class="row">
                            {{-- Ketua Penguji --}}
                            <div class="col-md-4 mb-24">
                                <label class="form-label">Ketua Penguji</label>
                                <select wire:model.lazy="examiner_chairman" class="form-control">
                                    <option value="">Pilih Dosen</option>
                                    @foreach ($lecturers as $lecturer)
                                        @if ($lecturer->id != $examiner_1 && $lecturer->id != $examiner_2 && $lecturer->id != $examiner_3)
                                            <option value="{{ $lecturer->id }}">{{ $lecturer->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            {{-- Penguji 1 --}}
                            <div class="col-md-4 mb-24">
                                <label class="form-label">Penguji 1</label>
                                <select wire:model.lazy="examiner_1" class="form-control">
                                    <option value="">Pilih Dosen</option>
                                    @foreach ($lecturers as $lecturer)
                                        @if ($lecturer->id != $examiner_chairman && $lecturer->id != $examiner_2 && $lecturer->id != $examiner_3)
                                            <option value="{{ $lecturer->id }}">{{ $lecturer->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            {{-- Penguji 2 (Pembimbing 1) --}}
                            <div class="col-md-4 mb-24">
                                <label class="form-label">Penguji 2 (Pembimbing 1)</label>
                                <select wire:model.lazy="examiner_2" class="form-control">
                                    <option value="">Pilih Dosen</option>
                                    @foreach ($lecturers as $lecturer)
                                        @if ($lecturer->id != $examiner_chairman && $lecturer->id != $examiner_1)
                                            <option value="{{ $lecturer->id }}">{{ $lecturer->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @elseif ($exam == 'Skripsi')
                        <div class="row">
                            {{-- Ketua Penguji --}}
                            <div class="col-md-3 mb-24">
                                <label class="form-label">Ketua Penguji</label>
                                <select wire:model.lazy="examiner_chairman" class="form-control">
                                    <option value="">Pilih Dosen</option>
                                    @foreach ($lecturers as $lecturer)
                                        @if ($lecturer->id != $examiner_1 && $lecturer->id != $examiner_2 && $lecturer->id != $examiner_3)
                                            <option value="{{ $lecturer->id }}">{{ $lecturer->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            {{-- Penguji 1 --}}
                            <div class="col-md-3 mb-24">
                                <label class="form-label">Penguji 1</label>
                                <select wire:model.lazy="examiner_1" class="form-control">
                                    <option value="">Pilih Dosen</option>
                                    @foreach ($lecturers as $lecturer)
                                        @if ($lecturer->id != $examiner_chairman && $lecturer->id != $examiner_2 && $lecturer->id != $examiner_3)
                                            <option value="{{ $lecturer->id }}">{{ $lecturer->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            {{-- Penguji 2 (Pembimbing 1) --}}
                            <div class="col-md-3 mb-24">
                                <label class="form-label">Penguji 2 (Pembimbing 1)</label>
                                <select wire:model.lazy="examiner_2" class="form-control">
                                    <option value="">Pilih Dosen</option>
                                    @foreach ($lecturers as $lecturer)
                                        @if ($lecturer->id != $examiner_chairman && $lecturer->id != $examiner_1 && $lecturer->id != $examiner_3)
                                            <option value="{{ $lecturer->id }}">{{ $lecturer->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            {{-- Penguji 3 (Pembimbing 2) --}}
                            <div class="col-md-3 mb-24">
                                <label class="form-label">Penguji 3 (Pembimbing 2)</label>
                                <select wire:model.lazy="examiner_3" class="form-control">
                                    <option value="">Pilih Dosen</option>
                                    @foreach ($lecturers as $lecturer)
                                        @if ($lecturer->id != $examiner_chairman && $lecturer->id != $examiner_1 && $lecturer->id != $examiner_2)
                                            <option value="{{ $lecturer->id }}">{{ $lecturer->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

                    <div class="form-group mb-24">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" cols="30" rows="10" wire:model="description"></textarea>
                        @error('description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="gr-btn mt-15">
                        @php
                            $routeName = 'admin.show-document.' . Str::lower($exam);
                        @endphp
                        <a href="{{ route($routeName, $exam_id) }}" class="btn btn-danger btn-lg mr-15 fs-16">Back</a>
                        <button type="button" class="btn btn-primary btn-lg fs-16" wire:click="submit">
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:loading>
        <x-loading />
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script>
            function initFlatpickrScheduleDate() {
                const visibleInput = document.getElementById('schedule_date_input');
                const hiddenInput = document.getElementById('schedule_date_hidden');

                if (!visibleInput || visibleInput._flatpickr) return;

                flatpickr(visibleInput, {
                    dateFormat: "Y-m-d",
                    minDate: "{{ $startScheduleDate }}",
                    maxDate: "{{ $endScheduleDate }}",
                    disable: [
                        function(date) {
                            return date.getDay() === 0 || date.getDay() === 6; // disable Sabtu & Minggu
                        }
                    ],
                    position: "auto right",
                    appendTo: document.querySelector('.main-content'),
                    defaultDate: hiddenInput.value ?? null,
                    onChange: function(selectedDates, dateStr, instance) {
                        hiddenInput.value = dateStr;
                        hiddenInput.dispatchEvent(new Event('input')); // trigger Livewire binding
                    }
                });
            }

            document.addEventListener('DOMContentLoaded', () => {
                initFlatpickrScheduleDate();
            });

            Livewire.hook('message.processed', () => {
                setTimeout(() => {
                    initFlatpickrScheduleDate();
                }, 50); // delay untuk pastikan DOM siap
            });
        </script>
    @endpush
</div>
