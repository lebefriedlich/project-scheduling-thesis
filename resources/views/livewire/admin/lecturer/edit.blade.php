<div>
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 mb-24">
                            <div class="form-group">
                                <label class="form-label">NIP</label>
                                <input class="form-control" wire:model="nip">
                                @error('nip')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 mb-24">
                            <div class="form-group">
                                <label class="form-label">Name</label>
                                <input class="form-control" wire:model="name">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="gr-btn mt-15">
                        <a href="{{ route('admin.location.index') }}" class="btn btn-danger btn-lg mr-15 fs-16">Back</a>
                        <button type="button" class="btn btn-primary btn-lg fs-16" wire:click="submit">
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
