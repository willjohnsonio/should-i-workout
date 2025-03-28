<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkoutDecisionController;

// your routes below
Route::get('/', [WorkoutDecisionController::class, 'showForm']);
Route::post('/submit', [WorkoutDecisionController::class, 'handleForm']);
Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});

