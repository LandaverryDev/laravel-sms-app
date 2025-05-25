<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class TwilioWebhookController extends Controller
{
    // handles Twilio delivery status updates
    public function handleStatus(Request $request)
    {
        $sid = $request->input('MessageSid'); // this is Twilio's unique ID for the message
        $status = $request->input('MessageStatus'); // delivered, failed, etc.

        // log it if needed
        \Log::info("Twilio webhook for SID {$sid} with status: {$status}");

        // update the message record in the DB if we have it
        if ($sid && $status) {
            Message::where('twilio_sid', $sid)->update(['status' => $status]);
        }

        return response('Webhook received', 200);
    }
}
