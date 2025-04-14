<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Lecturer;
use App\Models\Periode;
use App\Models\Schedule;
use App\Models\Sempro;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SemproController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        // check periode
        $periode = Periode::where('type', 'sempro')
            ->where('end_registration', '>=', $now)->oldest()->first();


        // dd($periode);

        // if (!$periode) {
        //     // dd('Periode not found');
        //     return redirect(route('user.sempro.index'))->with('exists', 'Periode not found');
        // }

        $sempro = Sempro::where('user_id', Auth::user()->id)->first();

        $schedule = Schedule::where('exam_type', 'sempro')->where('exam_id', $sempro->id)->first();

        $isActiveForm = false;

        if ($schedule->end_time ?? null >= $now) {
            $isActiveForm = true;
        }

        $lecturer = Lecturer::all();

        $title = 'Sempro';

        // dd($lecturer);

        // return view with data_sempro, periode and lecturer
        return view('pages.sempro', compact('sempro', 'periode', 'lecturer', 'title', 'schedule', 'isActiveForm'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $sempro = Sempro::where('user_id', Auth::user()->id)->first();
        // dd($sempro);

        // if ($sempro->is_submit ?? false) {
        //     // dd('submit');
        //     // return view already submit
        //     return redirect()->back()->with('error', 'Anda Sudah Mengajukan Sempro');
        // }

        if (!$sempro) {
            $messages = [
                // 'required' => 'The :attribute field is required.',
                'exists' => 'The selected :attribute is invalid.',
                'file' => 'The :attribute must be a file.',
                'mimes' => 'The :attribute must be a file of type: :values.',
                'max' => 'The :attribute may not be greater than :max kilobytes.',
                // 'boolean' => 'The :attribute field must be submit or Draft.',
            ];

            $validator = Validator::make($request->all(), [
                // 'user_id' => 'required|exists:users,id',
                'periode_id' => 'required|exists:periodes,id',
                'mentor_id' => 'required|exists:lecturers,id',
                'second_mentor_id' => 'required|exists:lecturers,id',
                'doc_pra_proposal' => 'required|file|mimes:pdf|max:2048',
                // 'is_submit' => 'required|boolean',
            ], $messages);

            // dd($validator->errors());

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        if ($request->hasFile('doc_pra_proposal')) {
            $doc_pra_proposal = $request->file('doc_pra_proposal');
            $doc_pra_proposal_name = time() . '_' . 'sempro' . '-' . Auth::user()->nim . '.' . $doc_pra_proposal->getClientOriginalExtension();
            // $doc_pra_proposal->storeAs('sempro', $doc_pra_proposal_name);

            $storage = Storage::disk('public')->putFileAs(
                'sempro',
                $doc_pra_proposal,
                $doc_pra_proposal_name
            );
        }

        // dd($storage);

        Sempro::updateOrCreate(
            ['user_id' => Auth::user()->id],
            [
                'periode_id' => $request->periode_id,
                'mentor_id' => $request->mentor_id,
                'second_mentor_id' => $request->second_mentor_id,
                'doc_pra_proposal' => $storage ?? $sempro->doc_pra_proposal,
                'is_submit' => filter_var($request->is_submit, FILTER_VALIDATE_BOOLEAN),
            ]
        );

        // dd($data);

        if ($request->is_submit) {
            // dd('submit');
            $periode = Periode::find($request->periode_id);
            // dd($periode->quota);
            $update = $periode->update([
                'quota' => $periode->quota - 1,
            ]);
            // dd($update);
            return redirect()->back()->with('success', 'Sempro submitted successfully');
        } else {
            return redirect()->back()->with('success', 'Sempro saved as draft successfully');
        }
    }
}
