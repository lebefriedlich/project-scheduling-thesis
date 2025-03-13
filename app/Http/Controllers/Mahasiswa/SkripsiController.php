<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Lecture;
use App\Models\Periode;
use App\Models\Skripsi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SkripsiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $now = Carbon::now();

        // check periode
        $periode = Periode::where('type', 'semhas')
            ->where('start_schedule', '<=', $now)
            ->where('end_schedule', '>=', $now);

        if (!$periode) {
            // return view not found periode, can't submit sempro
        }

        $data_skripsi = Skripsi::with('semhas.sempro')
            ->whereHas('semhas.sempro', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })
            ->get();


        if ($data_skripsi->isEmpty()) {
            // return view not found semhas, can't submit semhas
        }

        $lecture = Lecture::all();

        // return view with data, periode and lecture
    }

    public function store(Request $request)
    {
        $messages = [
            'required' => 'The :attribute field is required.',
            'exists' => 'The selected :attribute is invalid.',
            'boolean' => 'The :attribute field must be submit or Draft.'
        ];

        $validator = Validator::make($request->all(), [
            'semhas_id' => 'required|exists:semhas,id',
            'periode_id' => 'required|exists:periodes,id',
            'is_submit' => 'required|boolean',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $skripsi = Skripsi::create($request->all());

        // return view with success message
    }

    public function show(string $id)
    {
        $data = Skripsi::with('semhas.sempro.mentor')
            ->where('id', $id)
            ->first();

        if (!$data) {
            // return view not found skripsi
        }

        // return view with data
    }

    public function update(Request $request, string $id)
    {
        $data = Skripsi::find($id);

        if (!$data) {
            // return view not found skripsi
        }

        $messages = [
            'required' => 'The :attribute field is required.',
            'exists' => 'The selected :attribute is invalid.',
            'boolean' => 'The :attribute field must be submit or Draft.'
        ];

        $validator = Validator::make($request->all(), [
            'semhas_id' => 'required|exists:semhas,id',
            'periode_id' => 'required|exists:periodes,id',
            'is_submit' => 'required|boolean',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data->update($request->all());

        // return view with success message
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Skripsi::find($id);

        if (!$data) {
            // return view not found skripsi
        }

        $data->delete();

        // return view with success message
    }
}
