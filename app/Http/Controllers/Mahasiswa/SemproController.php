<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Lecturer;
use App\Models\Periode;
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
            ->where('start_schedule', '<=', $now)
            ->where('end_schedule', '>=', $now);

        if (!$periode) {
            // return view not found periode, can't submit sempro
        }

        $data_sempro = Sempro::where('user_id', Auth::user()->id)->get();

        $lecturer = Lecturer::all();

        // return view with data_sempro, periode and lecturer
    }

    public function store(Request $request) {
        $messages = [
            'required' => 'The :attribute field is required.',
            'exists' => 'The selected :attribute is invalid.',
            'file' => 'The :attribute must be a file.',
            'mimes' => 'The :attribute must be a file of type: :values.',
            'max' => 'The :attribute may not be greater than :max kilobytes.',
            'boolean' => 'The :attribute field must be submit or Draft.',
        ];

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'periode_id' => 'required|exists:periodes,id',
            'mentor_id' => 'required|exists:lecturers,id',
            'second_mentor_id' => 'required|exists:lecturers,id',
            'doc_pra_proposal' => 'required|file|mimes:pdf|max:2048',
            'is_submit' => 'required|boolean',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $doc_pra_proposal = $request->file('doc_pra_proposal');
        $doc_pra_proposal_name = time() . '_' . 'sempro' . '-' . Auth::user()->name;
        $doc_pra_proposal->storeAs('sempro', $doc_pra_proposal_name);

        Sempro::create([
            'user_id' => Auth::user()->id,
            'periode_id' => $request->periode_id,
            'mentor_id' => $request->mentor_id,
            'second_mentor_id' => $request->second_mentor_id,
            'doc_pra_proposal' => $doc_pra_proposal_name,
        ]);

        // return redirect with success message
    }

    public function show($id)
    {
        $data_sempro = Sempro::with('mentor')->find($id);

        // return view with data
    }

    public function update(Request $request, $id){
        $sempro = Sempro::find($id);

        if (!$sempro) {
            // return view not found
        }

        if ($sempro->is_submit) {
            // return view already submit
        }

        $messages = [
            'required' => 'The :attribute field is required.',
            'exists' => 'The selected :attribute is invalid.',
            'file' => 'The :attribute must be a file.',
            'mimes' => 'The :attribute must be a file of type: :values.',
            'max' => 'The :attribute may not be greater than :max kilobytes.',
            'boolean' => 'The :attribute field must be submit or Draft.',
        ];

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'periode_id' => 'required|exists:periodes,id',
            'mentor_id' => 'required|exists:lecturers,id',
            'second_mentor_id' => 'required|exists:lecturers,id',
            'doc_pra_proposal' => 'required|file|mimes:pdf|max:2048',
            'is_submit' => 'required|boolean',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('doc_pra_proposal')) {
            // Hapus file lama jika ada
            if ($sempro->doc_pra_proposal) {
                Storage::delete('sempro/' . $sempro->doc_pra_proposal);
            }
    
            // Simpan file baru
            $doc_pra_proposal = $request->file('doc_pra_proposal');
            $doc_pra_proposal_name = time() . '_sempro_' . Auth::user()->name . '.' . $doc_pra_proposal->getClientOriginalExtension();
            $doc_pra_proposal->storeAs('sempro', $doc_pra_proposal_name);
    
            // Update nama file di database
            $sempro->doc_pra_proposal = $doc_pra_proposal_name;
        }

        $sempro->user_id = Auth::user()->id;
        $sempro->periode_id = $request->periode_id;
        $sempro->mentor_id = $request->mentor_id;
        $sempro->second_mentor_id = $request->second_mentor_id;
        $sempro->is_submit = $request->is_submit;
        $sempro->save();
    }

    public function destroy($id)
    {
        $sempro = Sempro::find($id);

        if (!$sempro) {
            // return view not found
        }

        if ($sempro->is_submit) {
            // return view already submit
        }

        if ($sempro->doc_pra_proposal) {
            Storage::delete('sempro/' . $sempro->doc_pra_proposal);
        }

        $sempro->delete();

        // return redirect with success message
    }
}
