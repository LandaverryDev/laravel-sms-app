<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::latest()->get();
        return view('campaigns.index', compact('campaigns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:campaigns,name',
            'description' => 'nullable|string',
        ]);

        Campaign::create($request->only('name', 'description'));

        return redirect()->route('campaigns.index')->with('success', 'Campaign created.');
    }
}
