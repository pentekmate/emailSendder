<?php

use App\Http\Controllers\CvController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/message',[MessageController::class,'store'])->middleware('throttle:sendMessage')->name('sendMessage');
Route::post('/payment',[PaymentController::class,'PaymentController@processPayment']);

Route::post('/create-payment-intent', [PaymentController::class, 'createPaymentIntent']);
Route::post('/saveCv',[CvController::class,'store']);

