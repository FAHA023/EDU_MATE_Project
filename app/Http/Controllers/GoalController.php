<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;


use Illuminate\Http\Request;
use App\Models\Goal;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    public function index()
{
    if (!Session::has('user')) {
        return redirect()->route('login');
    }

    $user = Session::get('user');

    // Fetch goals for the logged-in user
    $goals = Goal::where('user_id', $user->id)
                 ->orderBy('created_at', 'desc')
                 ->get();

    return view('goals.index', compact('user', 'goals'));
}


    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'target_date' => 'nullable|date',
    ]);

    $user = Session::get('user');

    Goal::create([
        'user_id' => $user->id,
        'title' => $request->title,
        'description' => $request->description,
        'progress' => 0,
        'target_date' => $request->target_date,
    ]);

    return redirect()->route('goals.index')->with('success', 'Goal added successfully!');
}





    public function update(Request $request, Goal $goal)
{
    // Validate progress
    $request->validate([
        'progress' => 'required|integer|min:0|max:100',
    ]);

    $goal->progress = $request->progress;
    $goal->save();

    return redirect()->route('goals.index')->with('success', 'Goal progress updated!');
}


    public function destroy(Goal $goal) {
        $goal->delete();
        return redirect()->back()->with('success', 'Goal deleted!');
    }
}
