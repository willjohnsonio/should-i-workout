<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkoutDecisionController extends Controller
{
    public function showForm()
    {
        return view('workout-form');
    }

    public function handleForm(Request $request)
    {
        $data = $request->validate([
            'soreness' => 'required|integer|min:1|max:10',
            'sleep' => 'required|numeric|min:0|max:24',
            'feel_like' => 'required|in:yes,no',
        ]);
    
        if ($data['feel_like'] === 'no') {
            // Intentionally throw an error
            throw new \Exception("Wrong Answer!! Go Workout! 😡 ");
        }
    
        $message = "Nice! Go crush your workout today 💪";
    
        return response()->json(['message' => $message]);
    }
}

