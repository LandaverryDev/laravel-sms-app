<?php

namespace App\Http\Controllers;

use App\Jobs\SendSmsJob;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class BulkSmsController extends Controller
{
    public function send(Request $request)
{
    $request->validate([
        'message' => 'required|string|max:1600',
        'csv_file' => 'nullable|file|mimes:csv,txt',
        'numbers' => 'nullable|string',
    ]);

    $sid    = env('TWILIO_SID');
    $token  = env('TWILIO_AUTH_TOKEN');
    $from   = env('TWILIO_PHONE_NUMBER');
    $twilio = new Client($sid, $token);

    $recipients = [];

    // use CSV if uploaded
    if ($request->hasFile('csv_file')) {
        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');
        while (($line = fgetcsv($handle)) !== false) {
            $recipients[] = trim($line[0]);
        }
        fclose($handle);
    }
    // otherwise, use typed-in numbers
    elseif ($request->filled('numbers')) {
        $recipients = array_map('trim', explode(',', $request->input('numbers')));
    }

    // if nothing provided, don't send anything
    if (empty($recipients)) {
        return back()->with('success', 'No valid numbers provided.');
    }

    $campaignId = $request->input('campaign_id'); // can be null
    // loop through and send
    foreach ($recipients as $to) {
        dispatch(new SendSmsJob($to, $request->input('message'), $campaignId));
    }


    return back()->with('success', 'Messages queued for delivery.');
}

}