<?php

namespace App\Jobs;

use App\Models\Contact;
use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Twilio\Rest\Client;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $to;
    protected $message;

    // job constructor — takes a phone number and message content
    public function __construct($to, $message)
    {
        $this->to = $to;
        $this->message = $message;
    }

    // what the job does when it's picked up by the worker
    public function handle()
    {
        // set up Twilio client using your .env credentials
        $twilio = new Client(
            env('TWILIO_SID'),
            env('TWILIO_AUTH_TOKEN')
        );

        // find the contact by phone or create them if they don't exist
        $contact = Contact::firstOrCreate(
            ['phone_number' => $this->to],
            ['name' => null] // we’ll fill this later if needed
        );

        // send the message and capture the Twilio message SID
        $twilioMessage = $twilio->messages->create($this->to, [
            'from' => env('TWILIO_PHONE_NUMBER'),
            'body' => $this->message,
        ]);

        // store the message in the DB linked to the contact
        $contact->messages()->create([
            'body' => $this->message,
            'status' => 'queued', // we'll update this via webhook later
            'twilio_sid' => $twilioMessage->sid ?? null,
        ]);
    }
}