<?php

use App\Http\Controllers\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/message',[MessageController::class,'store'])->middleware('throttle:sendMessage')->name('sendMessage');

