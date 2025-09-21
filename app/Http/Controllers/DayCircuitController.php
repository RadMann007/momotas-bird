<?php

namespace App\Http\Controllers;

use App\Models\Circuit;
use App\Models\DayCircuit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class DayCircuitController extends Controller //Step
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Day/Index', [
            'etapes' => DayCircuit::with(['circuit'])->get(),
            'circuits' => Circuit::all()
        ]);
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
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'circuit_id' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'distance' => 'required',
            'day' => 'required',
            'start' => 'required',
            'end' => 'required',
            'hotel_name' => 'required',
            'hotel_description' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('steps', 'public');
        }

        DayCircuit::create($data);

        return redirect()->route('days.index', $request->circuit_id)->with('success', 'Step added with success!');
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
    public function edit(String $id)
    {
        $step = DayCircuit::find($id);
        return Inertia::render('Day/Edit', [
            'step' => $step,
            'circuits' => Circuit::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DayCircuit $day)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'circuit_id' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'distance' => 'required',
            'day' => 'required',
            'start' => 'required',
            'end' => 'required',
            'hotel_name' => 'required',
            'hotel_description' => 'required',
        ]);

        $data = $request->except('image');

        // dd($data);
        if ($request->hasFile('image')) {

            //delete old image if exist
            if($day->image && Storage::disk('public')->exists($day->image)){
                Storage::disk('public')->delete($day->image);
            }

            $data['image'] = $request->file('image')->store('steps', 'public');
        }

        if($request->hasFile('image') == false){
            $data['image'] = $day->image;
        }

        $day->update($data);
        return redirect()->route('days.index')->with('success', 'Step updated!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $etape = DayCircuit::find($id);
        $etape->delete();
        return redirect()->route('circuits.index')->with('success', 'Step deleted!');
    }
}
