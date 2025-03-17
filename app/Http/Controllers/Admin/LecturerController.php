<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LecturerController extends Controller
{
    public function index()
    {
        $datas = Lecturer::all();

        dd($datas);
        // return the view with the data
    }

    public function store(Request $request)
    {
        $messages = [
            'required' => 'The :attribute field is required.',
            'numeric' => 'The :attribute field must be a number.',
            'digits' => 'The :attribute field must be :digits digits.',
            'unique' => 'The :attribute has already been taken.',
            'string' => 'The :attribute field must be a string.',
            'max' => 'The :attribute field must be less than :max characters.',
        ];

        $validation = Validator::make($request->all(), [
            'nip' => 'required|numeric|digits:18|unique:lecturers',
            'name' => 'required|string|max:255',
        ], $messages);

        if ($validation->fails()) {
            // return the error message
        }

        Lecturer::create($request->all());

        // return success message
    }

    public function show(string $id)
    {
        $lecturer = Lecturer::find($id);

        if (!$lecturer) {
            // return error not found message
        }

        // return the view with the data
    }

    public function update(Request $request, string $id)
    {
        $lecturer = Lecturer::find($id);

        if (!$lecturer) {
            // return error not found message
        }

        $messages = [
            'required' => 'The :attribute field is required.',
            'numeric' => 'The :attribute field must be a number.',
            'digits' => 'The :attribute field must be :digits digits.',
            'unique' => 'The :attribute has already been taken.',
            'string' => 'The :attribute field must be a string.',
            'max' => 'The :attribute field must be less than :max characters.',
        ];

        $validation = Validator::make($request->all(), [
            'nip' => 'required|numeric|digits:18|unique:lecturers,nip,' . $id,
            'name' => 'required|string|max:255',
        ]);

        if ($validation->fails()) {
            // return the error message
        }

        $lecturer->update($request->all());

        // return success message
    }

    public function destroy(string $id)
    {
        $lecturer = Lecturer::find($id);

        if (!$lecturer) {
            // return error not found message
        }

        $lecturer->delete();

        // return success message
    }
}
