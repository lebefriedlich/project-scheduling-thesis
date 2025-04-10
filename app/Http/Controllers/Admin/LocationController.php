<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    public function index()
    {
        $datas = Location::all();

        // return the view with the data
    }

    public function store(Request $request)
    {
        $messages = [
            'required' => 'The :attribute field is required.',
            'string' => 'The :attribute field must be a string.',
            'unique' => 'The :attribute has already been taken.',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:locations',
            'description' => 'nullable|string',
        ], $messages);

        if ($validator->fails()) {
            // return the error messages
        }

        Location::create($request->all());

        // return success message
    }

    public function show(string $id)
    {
        $location = Location::find($id);

        if (!$location) {
            // return error not found message
        }

        // return the view with the data
    }

    public function update(Request $request, string $id)
    {
        $location = Location::find($id);

        if (!$location) {
            // return error not found message
        }

        $messages = [
            'required' => 'The :attribute field is required.',
            'string' => 'The :attribute field must be a string.',
            'unique' => 'The :attribute has already been taken.',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:locations,name,' . $id,
            'description' => 'nullable|string',
        ], $messages);

        if ($validator->fails()) {
            // return the error messages
        }

        $location->update($request->all());

        // return success message
    }

    public function destroy(string $id)
    {
        $location = Location::find($id);

        if (!$location) {
            // return error not found message
        }

        $location->delete();

        // return success message
    }
}