<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class WebhookController extends Controller
{
    public function handleStatus(Request $request)
    {
        // get the Message SID and delivery status from Twilio's POST payload
        $sid = $request->input('MessageSid');
        $status = $request->input('MessageStatus');

        // find the message in our DB using the SID
        $message = Message::where('twilio_sid', $sid)->first();

        if ($message) {
            // update the status (delivered, failed, etc.)
            $message->update([
                'status' => $status,
            ]);
        }

        // Twilio expects a 200 OK response no matter what
        return response()->json(['success' => true]);
    }
}
