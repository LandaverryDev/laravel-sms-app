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
use App\Models\OptOut;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $to;
    protected $message;
    protected $campaignId;

    // job constructor — takes a phone number and message content
    
    public function __construct($to, $message, $campaignId = null)
    {
        $this->to = $to;
        $this->message = $message;
        $this->campaignId = $campaignId;
    }

    // what the job does when it's picked up by the worker
    public function handle()
{
    \Log::info("Campaign ID received in job: " . ($this->campaignId ?? 'null'));

    // Check if this number is opted out
    if (OptOut::where('phone_number', $this->to)->exists()) {
        \Log::info("SMS to {$this->to} skipped — number is opted out.");
        return;
    }

    $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

    $contact = Contact::firstOrCreate(
        ['phone_number' => $this->to],
        ['name' => null]
    );

    // Add opt-out instructions to message
    $messageWithOptOut = $this->message . ' Reply STOP to opt out.';

    $twilioMessage = $twilio->messages->create($this->to, [
        'from' => env('TWILIO_PHONE_NUMBER'),
        'body' => $messageWithOptOut,
    ]);

    // Store only original message in DB (not the appended text)
    $contact->messages()->create([
        'body' => $this->message,
        'status' => 'queued',
        'twilio_sid' => $twilioMessage->sid ?? null,
        'campaign_id' => $this->campaignId,
    ]);
}


}