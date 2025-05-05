<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Periode;
use App\Models\Schedule;
use App\Models\Semhas;
use App\Models\Sempro;
use App\Models\Skripsi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SkripsiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $now = Carbon::now();
        $today = $now->toDateString(); // Format: Y-m-d
        $currentTime = $now->format('H:i'); // Format: H:i:s

        // check periode
        $periode = Periode::where('type', 'semhas')
            ->where('end_registration', '>=', $now)->oldest()->first();

        $sempro = Sempro::with(['schedules', 'semhas.schedules', 'semhas.skripsi'])
            ->where('user_id', Auth::user()->id)
            ->first();

        // if ($sempro) {
        //     $schedule = $sempro->schedules->first();

        //     if (empty($schedule) || $schedule->schedule_date >= $now) {
        //         return redirect(route('user.sempro.index'));
        //     }
        // } else {
        //     return redirect(route('user.sempro.index'));
        // }

        $semhas = $sempro->semhas;

        // if ($semhas) {
        //     $schedule = $semhas->schedules->first();

        //     if (empty($schedule) || $schedule->schedule_date >= $now) {
        //         return redirect()->route('user.semhas.index');
        //     }
        // } else {
        //     return redirect()->route('user.semhas.index');
        // }

        $title = 'Skripsi';

        // return view with data, periode and lecture
        return view('pages.skripsi', compact('sempro', 'periode', 'title'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $now = Carbon::now();

        // check periode
        $periode = Periode::where('type', 'skripsi')
            ->where('end_registration', '>=', $now)->oldest()->first();

        $semhas = Semhas::with('sempro')
            ->whereHas('sempro', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })
            ->first();

        $sempro = Sempro::with('semhas.skripsi')
            ->where('user_id', Auth::id())
            ->first();

        if (!$sempro) {

            $messages = [
                'doc_skripsi.required' => 'Dokumen Skripsi tidak boleh kosong',
                'doc_skripsi.file' => 'File Skripsi harus berupa file',
                'doc_skripsi.mimes' => 'File Skripsi harus berupa file pdf',
                'doc_skripsi.max' => 'File Skripsi tidak boleh lebih dari 5MB',
            ];

            $validator = Validator::make($request->all(), [
                // 'semhas_id' => 'required|exists:semhas,id',
                // 'periode_id' => 'required|exists:periodes,id',
                'doc_skripsi' => 'required|file|mimes:pdf|max:5120',
                // 'is_submit' => 'required|boolean',
            ], $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        if ($request->hasFile('doc_skripsi')) {
            $file = $request->file('doc_skripsi');
            $filename = time() . '_' . 'skripsi' . '-' . Auth::user()->nim . '.' . $file->getClientOriginalExtension();

            $storage = Storage::disk('public')->putFileAs(
                'skripsi',
                $file,
                $filename
            );
        }

        $data = Skripsi::updateOrCreate(
            [
                'semhas_id' => $semhas->id,
            ],
            [
                'periode_id' => $periode->id,
                'doc_skripsi' => $storage ?? $sempro->semhas->skripsi->doc_skripsi,
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
            'boolean' => 'The :attribute field must be submit or Draft.',
            'file' => 'The :attribute must be a file.',
            'mimes' => 'The :attribute must be a file of type: pdf.',
            'max' => 'The :attribute may not be greater than 2MB.',
        ];

        $validator = Validator::make($request->all(), [
            // 'semhas_id' => 'required|exists:semhas,id',
            // 'periode_id' => 'required|exists:periodes,id',
            'doc_skripsi' => 'required|file|mimes:pdf|max:5120',
            // 'is_submit' => 'required|boolean',
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
