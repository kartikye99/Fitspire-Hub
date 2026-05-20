<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WaterLogController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'amount_ml' => 'required|integer|min:50|max:5000',
        ]);

        \Illuminate\Support\Facades\Auth::user()->waterLogs()->create([
            'amount_ml' => $request->amount_ml,
            'logged_at' => \Carbon\Carbon::today()->toDateString(),
        ]);

        return redirect()->back()->with('success', 'Hydration logged: Added ' . $request->amount_ml . 'ml.');
    }
}
