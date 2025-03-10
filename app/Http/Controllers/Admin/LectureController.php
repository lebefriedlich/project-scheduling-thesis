<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LectureController extends Controller
{
    public function index()
    {
        $datas = Lecture::all();

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
            'nip' => 'required|numeric|digits:18|unique:lectures',
            'name' => 'required|string|max:255',
        ], $messages);

        if ($validation->fails()) {
            // return the error message
        }

        Lecture::create($request->all());
        
        // return success message
    }

    public function show(string $id)
    {
        $lecture = Lecture::find($id);

        if (!$lecture) {
            // return error not found message
        }

        // return the view with the data
    }

    public function update(Request $request, string $id)
    {
        $lecture = Lecture::find($id);

        if (!$lecture) {
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
            'nip' => 'required|numeric|digits:18|unique:lectures,nip,' . $id,
            'name' => 'required|string|max:255',
        ]);

        if ($validation->fails()) {
            // return the error message
        }

        $lecture->update($request->all());

        // return success message
    }

    public function destroy(string $id)
    {
        $lecture = Lecture::find($id);

        if (!$lecture) {
            // return error not found message
        }

        $lecture->delete();

        // return success message
    }
}
