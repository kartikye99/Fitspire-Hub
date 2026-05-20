<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkoutController extends Controller
{
    public function index()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $workouts = $user->workouts()->orderBy('logged_at', 'desc')->orderBy('created_at', 'desc')->paginate(10);
        
        $totalCalories = $user->workouts()->sum('calories_burned');
        $totalDuration = $user->workouts()->sum('duration_minutes');
        $workoutCount = $user->workouts()->count();

        return view('workouts.index', compact('workouts', 'totalCalories', 'totalDuration', 'workoutCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'activity_name' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:1|max:1440',
            'intensity' => 'required|string|in:Low,Medium,High',
            'logged_at' => 'required|date|before_or_equal:today',
            'notes' => 'nullable|string|max:1000',
        ]);

        $burnRate = 8;
        switch ($request->intensity) {
            case 'Low':
                $burnRate = 5;
                break;
            case 'Medium':
                $burnRate = 8;
                break;
            case 'High':
                $burnRate = 12;
                break;
        }

        $caloriesBurned = $request->duration_minutes * $burnRate;

        \Illuminate\Support\Facades\Auth::user()->workouts()->create([
            'activity_name' => $request->activity_name,
            'duration_minutes' => $request->duration_minutes,
            'intensity' => $request->intensity,
            'calories_burned' => $caloriesBurned,
            'notes' => $request->notes,
            'logged_at' => $request->logged_at,
        ]);

        return redirect()->back()->with('success', 'Workout logged successfully! You burned ~' . $caloriesBurned . ' calories.');
    }

    public function destroy(\App\Models\Workout $workout)
    {
        if ($workout->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403);
        }

        $workout->delete();

        return redirect()->back()->with('success', 'Workout entry deleted.');
    }
}
