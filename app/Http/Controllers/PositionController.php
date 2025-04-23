<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    // List all positions
    public function index()
    {
        $positions = Position::all();
        return view('positions.index', compact('positions'));
    }

    // Show form to create a new position
    public function create()
    {
        return view('positions.create');
    }

    // Store a new position
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'base_salary' => 'required|numeric|min:0',
        ]);

        Position::create($validatedData);
        
        return redirect()->route('positions.index')->with('success', 'Position added successfully.');
    }
}
