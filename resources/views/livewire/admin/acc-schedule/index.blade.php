<div>
    <div class="main">
        <div class="main-content project">
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
                                    <div class="form-group">
                                        <label class="form-label">Tanggal Pelaksanaan</label>
                                        <input type="date" wire:model="schedule_date" min="{{ $startScheduleDate }}"
                                        max="{{ $endScheduleDate }}" class="form-control">
                                        @error('schedule_date')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
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
                                        <select wire:model.live.debounce.300ms="examiner_chairman" class="form-control">
                                            <option value="">Pilih Dosen</option>
                                            @foreach ($this->getFilteredLecturers([$examiner_1, $examiner_2]) as $lecturer)
                                                <option value="{{ $lecturer['id'] }}">{{ $lecturer['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Penguji 1 --}}
                                    <div class="col-md-4 mb-24">
                                        <label class="form-label">Penguji 1</label>
                                        <select wire:model.live.debounce.300ms="examiner_1" class="form-control">
                                            <option value="">Pilih Dosen</option>
                                            @foreach ($this->getFilteredLecturers([$examiner_chairman, $examiner_2]) as $lecturer)
                                                <option value="{{ $lecturer['id'] }}">{{ $lecturer['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Penguji 2 (Pembimbing 1) --}}
                                    <div class="col-md-4 mb-24">
                                        <label class="form-label">Penguji 2 (Pembimbing 1)</label>
                                        <select wire:model.live.debounce.300ms="examiner_2" class="form-control" disabled>
                                            <option value="">Pilih Dosen</option>
                                            @foreach ($this->getFilteredLecturers([$examiner_chairman, $examiner_1]) as $lecturer)
                                                <option value="{{ $lecturer['id'] }}">{{ $lecturer['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @elseif ($exam == 'Skripsi')
                                <div class="row">
                                    {{-- Ketua Penguji --}}
                                    <div class="col-md-3 mb-24">
                                        <label class="form-label">Ketua Penguji</label>
                                        <select wire:model.live.debounce.300ms="examiner_chairman" class="form-control">
                                            <option value="">Pilih Dosen</option>
                                            @foreach ($this->getFilteredLecturers([$examiner_1, $examiner_2, $examiner_3]) as $lecturer)
                                                <option value="{{ $lecturer['id'] }}">{{ $lecturer['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Penguji 1 --}}
                                    <div class="col-md-3 mb-24">
                                        <label class="form-label">Penguji 1</label>
                                        <select wire:model.live.debounce.300ms="examiner_1" class="form-control">
                                            <option value="">Pilih Dosen</option>
                                            @foreach ($this->getFilteredLecturers([$examiner_chairman, $examiner_2, $examiner_3]) as $lecturer)
                                                <option value="{{ $lecturer['id'] }}">{{ $lecturer['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Penguji 2 (Pembimbing 1) --}}
                                    <div class="col-md-3 mb-24">
                                        <label class="form-label">Penguji 2 (Pembimbing 1)</label>
                                        <select wire:model.live.debounce.300ms="examiner_2" class="form-control">
                                            <option value="">Pilih Dosen</option>
                                            @foreach ($this->getFilteredLecturers([$examiner_chairman, $examiner_1, $examiner_3]) as $lecturer)
                                                <option value="{{ $lecturer['id'] }}">{{ $lecturer['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Penguji 3 (Pembimbing 2) --}}
                                    <div class="col-md-3 mb-24">
                                        <label class="form-label">Penguji 3 (Pembimbing 2)</label>
                                        <select wire:model.live.debounce.300ms="examiner_3" class="form-control">
                                            <option value="">Pilih Dosen</option>
                                            @foreach ($this->getFilteredLecturers([$examiner_chairman, $examiner_1, $examiner_2]) as $lecturer)
                                                <option value="{{ $lecturer['id'] }}">{{ $lecturer['name'] }}</option>
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
                                <a href="{{ route($routeName, $exam_id) }}"
                                    class="btn btn-danger btn-lg mr-15 fs-16">Back</a>
                                <button type="button" class="btn btn-primary btn-lg fs-16" wire:click="submit">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
