<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeriodeController extends Controller
{
    public function index()
    {
        $datas = Periode::all();

        // return the view with the data
    }

    public function store(Request $request)
    {
        $messages = [
            'required' => 'The :attribute field is required.',
            'in' => 'The :attribute field must be one of the following types: :values.',
            'date' => 'The :attribute field must be a date.',
            'numeric' => 'The :attribute field must be a number.',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'type' => 'required|in:sempro,semhas,skripsi',
            'start_schedule' => 'required|date',
            'end_schedule' => 'required|date',
            'quota' => 'required|numeric',
        ], $messages);

        if ($validator->fails()) {
            // return the error message
        }

        Periode::create($request->all());

        // return success message
    }

    public function show(string $id)
    {
        $periode = Periode::find($id);

        if (!$periode) {
            // return error not found message
        }

        // return the view with the data
    }

    public function update(Request $request, string $id)
    {
        $periode = Periode::find($id);

        if (!$periode) {
            // return error not found message
        }

        $messages = [
            'required' => 'The :attribute field is required.',
            'in' => 'The :attribute field must be one of the following types: :values.',
            'date' => 'The :attribute field must be a date.',
            'numeric' => 'The :attribute field must be a number.',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'type' => 'required|in:sempro,semhas,skripsi',
            'start_schedule' => 'required|date',
            'end_schedule' => 'required|date',
            'quota' => 'required|numeric',
        ], $messages);

        if ($validator->fails()) {
            // return the error message
        }

        $periode->update($request->all());

        // return success message
    }

    public function destroy(string $id)
    {
        $periode = Periode::find($id);

        if (!$periode) {
            // return error not found message
        }

        $periode->delete();

        // return success message
    }
}