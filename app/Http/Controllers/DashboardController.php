<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $today = \Carbon\Carbon::today()->toDateString();

        // Get today's logs
        $todayWorkouts = $user->workouts()->whereDate('logged_at', $today)->get();
        $todayCalories = $todayWorkouts->sum('calories_burned');
        $todayMinutes = $todayWorkouts->sum('duration_minutes');

        $todayWater = $user->waterLogs()->whereDate('logged_at', $today)->sum('amount_ml');

        // Calculate Streak
        $workoutDates = $user->workouts()
            ->selectRaw('logged_at as date')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->pluck('date')
            ->map(function($date) {
                return \Carbon\Carbon::parse($date)->toDateString();
            })
            ->unique()
            ->values()
            ->toArray();

        $streak = 0;
        if (!empty($workoutDates)) {
            $latestWorkoutDate = \Carbon\Carbon::parse($workoutDates[0]);
            $todayCar = \Carbon\Carbon::today();
            $yesterdayCar = \Carbon\Carbon::today()->subDay();

            if ($latestWorkoutDate->equalTo($todayCar) || $latestWorkoutDate->equalTo($yesterdayCar)) {
                $streak = 1;
                $currentDate = $latestWorkoutDate;
                
                for ($i = 1; $i < count($workoutDates); $i++) {
                    $prevDate = \Carbon\Carbon::parse($workoutDates[$i]);
                    $diff = $currentDate->diffInDays($prevDate);
                    
                    if ($diff == 1) {
                        $streak++;
                        $currentDate = $prevDate;
                    } elseif ($diff == 0) {
                        continue;
                    } else {
                        break;
                    }
                }
            }
        }

        // Recent Workouts (last 5)
        $recentWorkouts = $user->workouts()->orderBy('logged_at', 'desc')->orderBy('created_at', 'desc')->take(5)->get();

        // Saved Ideas
        $savedIdeas = $user->savedIdeas()->take(4)->get();

        return view('dashboard', compact(
            'todayCalories',
            'todayMinutes',
            'todayWater',
            'streak',
            'recentWorkouts',
            'savedIdeas'
        ));
    }
}
