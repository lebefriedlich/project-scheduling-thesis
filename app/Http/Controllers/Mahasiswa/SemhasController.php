<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Lecture;
use App\Models\Periode;
use App\Models\Semhas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SemhasController extends Controller
{
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

        $data_semhas = Semhas::with('sempro')
            ->whereHas('sempro', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })
            ->get();

        if ($data_semhas->isEmpty()) {
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
            'boolean' => 'The :attribute field must be submit or Draft.',
        ];

        $validator = Validator::make($request->all(), [
            'sempro_id' => 'required|exists:sempros,id',
            'periode_id' => 'required|exists:periodes,id',
            'kompre' => 'required',
            'is_submit' => 'required|boolean',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Semhas::create([
            'sempro_id' => $request->sempro_id,
            'periode_id' => $request->periode_id,
            'kompre' => $request->kompre,
            'is_submit' => $request->is_submit,
        ]);

        // return success message
    }

    public function show(string $id)
    {
        $data = Semhas::with(['sempro', 'sempro.mentor'])->find($id);

        if (!$data) {
            // return view not found
        }
    }

    public function update(Request $request, string $id)
    {
        $semhas = Semhas::find($id);

        if (!$semhas) {
            // return view not found
        }

        $messages = [
            'required' => 'The :attribute field is required.',
            'exists' => 'The selected :attribute is invalid.',
            'boolean' => 'The :attribute field must be submit or Draft.',
        ];

        $validator = Validator::make($request->all(), [
            'sempro_id' => 'required|exists:sempros,id',
            'periode_id' => 'required|exists:periodes,id',
            'kompre' => 'required',
            'is_submit' => 'required|boolean',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $semhas->update($request->all());

        // return success message
    }

    public function destroy(string $id)
    {
        $semhas = Semhas::find($id);

        if (!$semhas) {
            // return view not found
        }

        $semhas->delete();

        // return success message
    }
}
