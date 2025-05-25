<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmsController;

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