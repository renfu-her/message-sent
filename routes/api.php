<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\MailController;

Route::post('/send-mail', [MailController::class, 'sendMail'])->name('send-mail');