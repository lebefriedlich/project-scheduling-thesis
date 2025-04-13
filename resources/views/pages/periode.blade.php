<x-layouts.layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container-fluid py-4">
        <div class="card w-100">
            <div class="card-body p-3">
                <h4 class="text-uppercase">Ajukan Jadwal Periode</h4>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Nama</label>
                            <input class="form-control" type="text" value=" ">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Periode</label>
                        <input class="form-control" type="text" value=" ">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Mentor</label>
                        <select class="form-control" id="exampleFormControlSelect1">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Mentor</label>
                        <input class="form-control" type="text" value=" ">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Upload File</label>
                        <input type="file" class="form-control" name="fileUpload">
                    </div>
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
