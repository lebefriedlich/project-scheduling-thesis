<div>
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 mb-24">
                            <div class="form-group">
                                <label class="form-label">Nama Lokasi</label>
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

                    <div class="gr-btn mt-15">
                        <a href="{{ route('admin.location.index') }}" class="btn btn-danger btn-lg mr-15 fs-16">Back</a>
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
