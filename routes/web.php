<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\BulkSmsController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\TwilioWebhookController;

// still keeping the default Laravel welcome page
Route::get('/', function () {
    return view('welcome');
});

// shows the SMS form I built earlier
Route::get('/send-sms', function () {
    return view('send-sms');
});

// handles the form submit and actually sends the text
Route::post('/send-sms', [SmsController::class, 'send'])->name('sms.send');

// shows the bulk SMS form
Route::get('/bulk-sms', function () {
    return view('bulk-sms');
});

// handles the bulk form submit
Route::post('/bulk-sms', [BulkSmsController::class, 'send'])->name('bulk-sms.send');

Route::post('/twilio/status', [WebhookController::class, 'handleStatus']);

// Twilio delivery status webhook route
Route::post('/twilio/status', [TwilioWebhookController::class, 'handleStatus']);
