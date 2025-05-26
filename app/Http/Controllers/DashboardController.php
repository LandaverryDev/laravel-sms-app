<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index(Request $request)
{
    
    $query = Contact::with(['messages.campaign']); 

    // Filter by phone number
    if ($request->filled('phone')) {
        $query->where('phone_number', 'like', '%' . $request->phone . '%');
    }

    // Filter by message status
    if ($request->filled('status')) {
        $query->whereHas('messages', function ($q) use ($request) {
            $q->where('status', $request->status);
        });
    }

    $contacts = $query->latest()->get();

    return view('dashboard', compact('contacts'));
}

}
