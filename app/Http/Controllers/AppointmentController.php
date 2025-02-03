<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // Book an available time slot
    public function store(Request $request)
    {
        $request->validate([
            'time_slot_id' => 'required|exists:time_slots,id',
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|string|email|max:255',
        ]);

        $timeSlot = TimeSlot::findOrFail($request->time_slot_id);

        if ($timeSlot->is_booked) {
            return response()->json(['message' => 'Time slot is already booked'], 400);
        }

        $appointment = Appointment::create([
            'time_slot_id' => $timeSlot->id,
            'client_name' => $request->client_name,
            'client_email' => $request->client_email,
        ]);

        $timeSlot->update(['is_booked' => true]);

        return response()->json($appointment, 201);
    }

    // Retrieve a list of upcoming appointments
    public function index()
    {
        $appointments = Appointment::whereHas('timeSlot', function ($query) {
            $query->where('start_time', '>=', now());
        })->get();

        return response()->json($appointments, 200);
    }
}
