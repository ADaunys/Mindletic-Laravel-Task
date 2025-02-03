<?php

use App\Http\Controllers\PsychologistController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\AppointmentController;

// Added additional Validation, but left the original one just for show
Route::post('/register', [AuthController::class, 'register']);

Route::post('/psychologists', [PsychologistController::class, 'store']);
// Added Sanctum to secure the routes
Route::middleware('auth:sanctum')->get('/psychologists', [PsychologistController::class, 'index']);

Route::post('/psychologists/{id}/time-slots', [TimeSlotController::class, 'store']);
Route::get('/psychologists/{id}/time-slots', [TimeSlotController::class, 'index']);
Route::put('/time-slots/{id}', [TimeSlotController::class, 'update']);
Route::delete('/time-slots/{id}', [TimeSlotController::class, 'destroy']);

// Added Sanctum to secure the routes
Route::middleware('auth:sanctum')->post('/appointments', [AppointmentController::class, 'store']);
Route::get('/appointments', [AppointmentController::class, 'index']);