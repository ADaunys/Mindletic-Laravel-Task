<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Psychologist;
use Illuminate\Http\Request;

class PsychologistController extends Controller
{
    // Create a new psychologist profile
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:psychologists,email',
        ]);
    
        $psychologist = Psychologist::create($request->all());
        $token = $psychologist->createToken('Psychologist Token')->plainTextToken;
        return response()->json([
            $psychologist,
            'token' => $token,
        ], 201);
    }
    
    // Retrieve a list of psychologists
    public function index()
    {
        $psychologists = Psychologist::all();
        return response()->json($psychologists, 200);
    }
}
