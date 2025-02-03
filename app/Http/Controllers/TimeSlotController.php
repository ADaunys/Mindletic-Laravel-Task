<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TimeSlotController extends Controller
{
    // Add time slots for a psychologist
    public function store(Request $request, $id)
    {
        $request->validate([
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);
    
        // Get the psychologist by ID
        $psychologist = Psychologist::findOrFail($id);
    
        // Check for overlapping time slots
        $overlap = TimeSlot::where('psychologist_id', $psychologist->id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                      ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                      ->orWhere(function ($query) use ($request) {
                          $query->where('start_time', '<', $request->start_time)
                                ->where('end_time', '>', $request->end_time);
                      });
            })
            ->exists();
    
        if ($overlap) {
            return response()->json(['message' => 'Time slot overlaps with an existing one'], 400);
        }
    
        // Create the time slot
        $timeSlot = $psychologist->timeSlots()->create([
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);
    
        return response()->json($timeSlot, 201);
    }

    // View available time slots for a psychologist
    public function index($id)
    {
        $psychologist = Psychologist::findOrFail($id);
        $timeSlots = $psychologist->timeSlots()->where('is_booked', false)->get();

        return response()->json($timeSlots, 200);
    }

    // Update a time slot (mark it as booked)
    public function update(Request $request, $id)
    {
        $request->validate([
            'is_booked' => 'required|boolean',
        ]);
    
        // Get the time slot to be updated
        $timeSlot = TimeSlot::findOrFail($id);
    
        // Check for overlap if times are being updated (only if start_time or end_time is changed)
        if ($request->has('start_time') || $request->has('end_time')) {
            $overlap = TimeSlot::where('psychologist_id', $timeSlot->psychologist_id)
                ->where(function ($query) use ($request, $timeSlot) {
                    // Check if the new time range overlaps
                    $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                          ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                          ->orWhere(function ($query) use ($request, $timeSlot) {
                              $query->where('start_time', '<', $request->start_time)
                                    ->where('end_time', '>', $request->end_time);
                          });
                })
                ->where('id', '!=', $timeSlot->id)  // Exclude the current time slot from the check
                ->exists();
    
            if ($overlap) {
                return response()->json(['message' => 'Time slot overlaps with an existing one'], 400);
            }
        }
    
        // Update the time slot
        $timeSlot->update($request->all());
    
        return response()->json($timeSlot, 204);
    }

    // Delete a time slot
    public function destroy($id)
    {
        $timeSlot = TimeSlot::findOrFail($id);
        $timeSlot->delete();

        return response()->json(null, 204);
    }
}
