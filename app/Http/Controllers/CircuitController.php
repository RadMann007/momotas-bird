<?php

namespace App\Http\Controllers;

use App\Models\Circuit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CircuitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Circuit/Index', [
            'circuits' => Circuit::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Circuit/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'duration' => 'required',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'start' => 'required',
            'end' => 'required',
            'distance' => 'required', 
            'truck_disponibility' =>'required',
            'price_3_pers' => 'required',
            'price_6_pers'=> 'required',
            'price_max_pers' => 'required',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('circuits', 'public');
        }

        $circuit = Circuit::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('circuits', 'public');
                $circuit->images()->create([
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('circuits.index')->with('success', 'Circuit créé avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Circuit $circuit)
    {
        return Inertia::render('Circuit/Show', [
            'circuit' => $circuit->load('days', 'images')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $circuit = Circuit::with('images')->findOrFail($id);
        return Inertia::render('Circuit/Edit', [
            'circuit' => $circuit
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Circuit $circuit)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'duration' => 'required',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'start' => 'required',
            'end' => 'required',
            'distance' => 'required', 
            'truck_disponibility' =>'required',
            'price_3_pers' => 'required',
            'price_6_pers'=> 'required',
            'price_max_pers' => 'required',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->except('image');

        // dd($data);
        if ($request->hasFile('image')) {

            //delete old image if exist
            if($circuit->image && Storage::disk('public')->exists($circuit->image)){
                Storage::disk('public')->delete($circuit->image);
            }

            $data['image'] = $request->file('image')->store('circuits', 'public');
        }

        if($request->hasFile('image') == false){
            $data['image'] = $circuit->image;
        }

        //Gallery image
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('circuits', 'public');
                $circuit->images()->create([
                    'path' => $path,
                ]);
            }
        }

        $circuit->update($data);
        return redirect()->route('circuits.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Circuit $circuit)
    {
        $circuit->delete();
        return redirect()->route('circuits.index');
    }
}
