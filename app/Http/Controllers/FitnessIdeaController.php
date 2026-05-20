<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FitnessIdeaController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\FitnessIdea::query();

        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('equipment_needed', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        $ideas = $query->get();
        
        $savedIdeaIds = \Illuminate\Support\Facades\Auth::user()->savedIdeas()->pluck('fitness_ideas.id')->toArray();

        return view('ideas.index', compact('ideas', 'savedIdeaIds'));
    }

    public function save(\App\Models\FitnessIdea $idea)
    {
        \Illuminate\Support\Facades\Auth::user()->savedIdeas()->syncWithoutDetaching($idea->id);
        return redirect()->back()->with('success', 'Idea saved to your routine!');
    }

    public function unsave(\App\Models\FitnessIdea $idea)
    {
        \Illuminate\Support\Facades\Auth::user()->savedIdeas()->detach($idea->id);
        return redirect()->back()->with('success', 'Idea removed from your routine.');
    }
}
