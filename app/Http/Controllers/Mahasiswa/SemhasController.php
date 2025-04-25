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

        $periode = Periode::where('type', 'semhas')
            ->where('end_registration', '>=', $now)->oldest()->first();


        $semhas = Semhas::with(['sempro', 'sempro.schedules'])
            ->whereHas('sempro', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })
            ->first();
        
        if ($semhas) {
            $schedule = $semhas->sempro->schedules->first();

            if ($schedule && $schedule->schedule_date >= $now) {
                return redirect()->route('user.sempro.index');
            }
        } else {
            return redirect()->route('user.sempro.index');
        }

        $title = 'Semhas';

        return view('pages.semhas', compact('semhas', 'periode', 'title'));
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
                'kompre.required' => 'File Kompre tidak boleh kosong',
                'kompre.file' => 'File Kompre harus berupa file',
                'kompre.mimes' => 'File Kompre harus berupa file dengan format pdf',
                'kompre.max' => 'File Kompre tidak boleh lebih dari 5 MB',
            ];

            $validator = Validator::make($request->all(), [
                // 'sempro_id' => 'required|exists:sempros,id',
                // 'periode_id' => 'required|exists:periodes,id',
                'kompre' => 'required|file|mimes:pdf|max:5120',
                // 'is_submit' => 'required|boolean',
            ], $messages);

            // dd($validator->errors());

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        if ($request->hasFile('kompre')) {
            $file = $request->file('kompre');
            $filename = time() . '_' . 'semhas' . '-' . Auth::user()->nim . '.' . $file->getClientOriginalExtension();

            $storage = Storage::disk('public')->putFileAs(
                'semhas',
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
