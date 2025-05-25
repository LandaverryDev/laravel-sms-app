<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class BulkSmsController extends Controller
{
    public function send(Request $request)
    {
        // make sure user submitted numbers and a message
        $request->validate([
            'numbers' => 'required|string',
            'message' => 'required|string|max:1600',
        ]);

        // grab Twilio credentials from .env
        $sid    = env('TWILIO_SID');
        $token  = env('TWILIO_AUTH_TOKEN');
        $from   = env('TWILIO_PHONE_NUMBER');

        // start Twilio client
        $twilio = new Client($sid, $token);

        // split phone numbers by comma
        $numbers = explode(',', $request->input('numbers'));
        $message = $request->input('message');

        // send the message to each number
        foreach ($numbers as $to) {
            try {
                $twilio->messages->create(trim($to), [
                    'from' => $from,
                    'body' => $message,
                ]);
            } catch (\Exception $e) {
                // optional: log the failure if needed
                // Log::error("Failed to send to $to: " . $e->getMessage());
            }
        }

        // redirect back with a flash message
        return back()->with('success', 'Messages queued for delivery.');
    }
}