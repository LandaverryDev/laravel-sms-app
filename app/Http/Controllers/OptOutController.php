<?php

namespace App\Http\Controllers;

use App\Models\OptOut;
use Illuminate\Http\Request;

class OptOutController extends Controller
{
    public function index()
    {
        $optOuts = OptOut::latest()->get();
        return view('opt-outs.index', compact('optOuts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'phone_number' => ['required', 'regex:/^\+1\d{10}$/', 'unique:opt_outs,phone_number']
        ]);

        OptOut::create([
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->route('opt-outs.index')->with('success', 'Phone number added to opt-outs.');
    }

    public function destroy($id)
    {
        OptOut::findOrFail($id)->delete();

        return redirect()->route('opt-outs.index')->with('success', 'Phone number removed from opt-outs.');
    }
}
