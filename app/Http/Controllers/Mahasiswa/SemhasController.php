<?php

namespace App\Http\Controllers\Mahasiswa;

use Carbon\Carbon;
use App\Models\Semhas;
use App\Models\Sempro;
use App\Models\Periode;
use App\Models\Lecturer;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SemhasController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        // check periode
        $periode = Periode::where('type', 'semhas')
            ->where('end_registration', '>=', $now)->oldest()->first();

            // dd($periode);

        // if (!$periode) {
        //     // return view not found periode, can't submit sempro
        // }

        $semhas = Semhas::with('sempro')
            ->whereHas('sempro', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })
            ->first();

        $sempro = Sempro::where('user_id', Auth::user()->id)->first();

        $schedule = Schedule::where('exam_type', 'sempro')->where('exam_id', $sempro->id)->first();

        $isActiveForm = false;

        if ($schedule->end_time ?? null >= $now) {
            $isActiveForm = true;
        }

        // dd($semhas);

        // if ($data_semhas->isEmpty()) {
        //     // return view not found semhas, can't submit semhas
        // }

        $lecturer = Lecturer::all();

        $title = 'Semhas';

        // return view with data, periode and lecture
        return view('pages.semhas', compact('semhas', 'periode', 'lecturer', 'title', 'schedule', 'isActiveForm'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $now = Carbon::now();

        // check periode
        $periode = Periode::where('type', 'semhas')
            ->where('end_registration', '>=', $now)->oldest()->first();

        $sempro = Sempro::where('user_id', Auth::user()->id)->first();

        $semhas = Semhas::with('sempro')
            ->whereHas('sempro', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })
            ->first();

        if (!$semhas) {

            $messages = [
                'required' => 'The :attribute field is required.',
                'exists' => 'The selected :attribute is invalid.',
                'boolean' => 'The :attribute field must be submit or Draft.',
                'file' => 'The :attribute must be a file.',
                'mimes' => 'The :attribute must be a file of type: pdf.',
                'max' => 'The :attribute may not be greater than 2MB.',
            ];

            $validator = Validator::make($request->all(), [
                // 'sempro_id' => 'required|exists:sempros,id',
                // 'periode_id' => 'required|exists:periodes,id',
                'kompre' => 'required|file|mimes:pdf|max:2048',
                // 'is_submit' => 'required|boolean',
            ], $messages);

            // dd($validator->errors());

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        if ($request->hasFile('kompre')) {
            $file = $request->file('kompre');
            $filename = time() . '_' . 'sempro' . '-' . Auth::user()->nim . '.' . $file->getClientOriginalExtension();

            $storage = Storage::disk('public')->putFileAs(
                'sempro',
                $file,
                $filename
            );
        }

        $data = Semhas::updateOrCreate(
            [
                'sempro_id' => $sempro->id,
            ],
            [
                'periode_id' => $periode->id,
                'kompre' => $storage ?? $semhas->kompre,
                'is_submit' => filter_var($request->is_submit, FILTER_VALIDATE_BOOLEAN),
            ]
        );

        // dd($data);

        if ($request->is_submit) {
            // dd('submit');
            // $periode = Periode::find($request->periode_id);
            // dd($periode->quota);
            $update = $periode->update([
                'quota' => $periode->quota - 1,
            ]);
            // dd($update);
            return redirect()->back()->with('success', 'Semhas submitted successfully');
        } else {
            return redirect()->back()->with('success', 'Semhas saved as draft successfully');
        }
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
