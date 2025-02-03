<?php

use App\Http\Controllers\PsychologistController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\AppointmentController;

Route::post('/psychologists', [PsychologistController::class, 'store']);
Route::get('/psychologists', [PsychologistController::class, 'index']);

Route::post('/psychologists/{id}/time-slots', [TimeSlotController::class, 'store']);
Route::get('/psychologists/{id}/time-slots', [TimeSlotController::class, 'index']);
Route::put('/time-slots/{id}', [TimeSlotController::class, 'update']);
Route::delete('/time-slots/{id}', [TimeSlotController::class, 'destroy']);

Route::post('/appointments', [AppointmentController::class, 'store']);
Route::get('/appointments', [AppointmentController::class, 'index']);