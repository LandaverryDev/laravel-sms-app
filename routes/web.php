<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\BulkSmsController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\TwilioWebhookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OptOutController;
use App\Http\Controllers\CampaignController;

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

// Twilio delivery status webhook route
Route::post('/twilio/status', [TwilioWebhookController::class, 'handleStatus']);

// shows the dashboard with all contacts and their message history
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/opt-outs', [OptOutController::class, 'index'])->name('opt-outs.index');
Route::post('/opt-outs', [OptOutController::class, 'store'])->name('opt-outs.store');
Route::delete('/opt-outs/{id}', [OptOutController::class, 'destroy'])->name('opt-outs.destroy');

Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaigns.store');