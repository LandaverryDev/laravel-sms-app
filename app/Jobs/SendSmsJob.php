<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Twilio\Rest\Client;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $to;      // who we’re sending to
    protected $message; // what we're sending

    // constructor: this runs when we create the job (new SendSmsJob(...))
    public function __construct($to, $message)
    {
        $this->to = $to;
        $this->message = $message;
    }

    // this is what actually runs when the queue worker picks up the job
    public function handle()
    {
        // set up Twilio client using .env credentials
        $twilio = new Client(
            env('TWILIO_SID'),
            env('TWILIO_AUTH_TOKEN')
        );

        // send the message
        $twilio->messages->create($this->to, [
            'from' => env('TWILIO_PHONE_NUMBER'),
            'body' => $this->message,
        ]);
    }
}