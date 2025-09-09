<?php

namespace App\Http\Controllers;

use App\Models\Circuit;
use App\Models\DayCircuit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DayCircuitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Day/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Day/Create', [
            'circuits' => Circuit::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'circuit_id' => 'required'
        ]);

        DayCircuit::create($data);

        return redirect()->route('circuits.index')->with('success', 'Day ajouté');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('Day/Edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
