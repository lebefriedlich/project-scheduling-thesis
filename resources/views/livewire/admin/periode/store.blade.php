<div>
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 mb-24">
                            <div class="form-group">
                                <label class="form-label">Nama Periode</label>
                                <input class="form-control" wire:model="name">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-24">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" cols="30" rows="10" wire:model="description"></textarea>
                        @error('description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12 mb-24">
                            <div class="form-group">
                                <label class="form-label">Tipe</label>
                                <select class="form-control custom-select select2" wire:model="type">
                                    <option value="">Pilih Tipe</option>
                                    <option value="sempro">Sempro</option>
                                    <option value="semhas">Semhas</option>
                                    <option value="skripsi">Skripsi</option>
                                </select>
                                @error('type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Terakhir Pendaftaran</label>
                                <input type="date" wire:model="end_registration" class="form-control">
                                @error('end_registration')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12 mb-24">
                            <div class="form-group">
                                <label class="form-label">Mulai Pelaksanaan</label>
                                <input type="date" wire:model="start_schedule" class="form-control">
                                @error('start_schedule')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 mb-24">
                            <div class="form-gruoup">
                                <label class="form-label">Akhir Pelaksanaan</label>
                                <input type="date" wire:model="end_schedule" class="form-control">
                                @error('end_schedule')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12 mb-24">
                            <div class="form-group">
                                <label class="form-label">Kuota</label>
                                <input type="number" wire:model="quota" class="form-control" min="1">
                                @error('quota')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="gr-btn mt-15">
                        <a href="{{ route('admin.periode.index') }}" class="btn btn-danger btn-lg mr-15 fs-16">Back</a>
                        <button type="button" class="btn btn-primary btn-lg fs-16" wire:click="submit">
                            Submit
                        </button>
                        <div wire:loading>
                            <x-loading />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
