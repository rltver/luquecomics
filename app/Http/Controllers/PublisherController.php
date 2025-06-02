<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublisherController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('publishers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required','string','min:3','max:10000'],
            'logo' => ['required', 'image', 'mimes:jpg,jpeg,png,gif', 'max:4096'],
            'creation_date' => ['required','date','date_format:Y-m-d'],
        ]);
        $path = $request->file('logo')->store('publishers', 'public');

        $character = Publisher::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'logo' => basename($path),
            'creation_date' => $validatedData['creation_date'],
            'slug' => Str::slug($validatedData['name']).uniqid(),
        ]);

        return redirect()->route('publishers.create')->with('success', 'Publisher added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Publisher $publisher)
    {
        $comics = $publisher->comics()->where('stock', '>', 0)->orderBy('stock', 'asc')->take(8)->get(); // comics with less stock without beaing 0

        return view('publishers.show', compact('publisher', 'comics'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Publisher $publisher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Publisher $publisher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publisher $publisher)
    {
        //
    }
}
