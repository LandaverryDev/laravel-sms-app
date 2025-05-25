<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class SmsController extends Controller
{
    // handles the form submit and sends the SMS via Twilio
    public function send(Request $request)
    {
        // get phone number and message from the form
        $to = $request->input('recipient');
        $message = $request->input('message');

        // grab Twilio creds from the .env file
        $sid    = env('TWILIO_SID');
        $token  = env('TWILIO_AUTH_TOKEN');
        $from   = env('TWILIO_PHONE_NUMBER');

        // send the message
        try {
            $twilio = new Client($sid, $token);
            $twilio->messages->create($to, [
                'from' => $from,
                'body' => $message
            ]);
        } catch (\Exception $e) {
            // if Twilio throws an error, just dump it for now
            return back()->with('success', 'Failed to send SMS: ' . $e->getMessage());
        }

        // send them back with a little success message
        return back()->with('success', 'SMS sent!');
    }
}