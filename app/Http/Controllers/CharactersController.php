<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Comic;
use App\Models\OrderItem;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CharactersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $characters = Character::query()
            ->with('publisher')
            ->when(request('publishers'), function($query) {
                $query->where('publisher_id', request('publishers'));
            })
            ->when(request('decade'), function($query) {
                $startYear = request('decade');
                $endYear = $startYear + 9;
                $query->whereBetween('first_appearance', ["$startYear-01-01", "$endYear-12-31"]);
            })
            ->when(request('order_by'), function($query) {
                switch(request('order_by')) {
                    case 'name_desc':
                        return $query->orderBy('name', 'desc');
                    case 'appearance_asc':
                        return $query->orderBy('first_appearance');
                    case 'appearance_desc':
                        return $query->orderBy('first_appearance', 'desc');
                    default: // name_asc
                        return $query->orderBy('name');
                }
            }, function($query) {
                return $query->orderBy('name');
            })
            ->paginate(12);

        $publishers = Publisher::orderBy('name')->get();

        // Generar décadas disponibles (ej: 1930, 1940, etc.)
        $oldestCharacter = Character::oldest('first_appearance')->first();
        $firstYear = $oldestCharacter ? $oldestCharacter->first_appearance->year : date('Y');
        $lastYear = date('Y');
        $decades = [];
        for ($year = floor($firstYear / 10) * 10; $year <= $lastYear; $year += 10) {
            array_push($decades, $year);
        }

        return view('characters.index', compact('characters', 'publishers', 'decades','firstYear', 'lastYear'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $publishers = Publisher::all();
        return view('characters.create', compact('publishers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required','string','min:3','max:10000'],
            'publisher_id' => ['required','numeric','exists:publishers,id'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,gif', 'max:4096'],
            'first_appearance' => ['required','date','date_format:Y-m-d'],
        ]);
        $path = $request->file('image')->store('characters', 'public');

        $character = Character::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'publisher_id' => $validatedData['publisher_id'],
            'image' => basename($path),
            'first_appearance' => $validatedData['first_appearance'],
            'slug' => Str::slug($validatedData['name']).uniqid(),
        ]);

        return redirect()->route('characters.create')->with('success', 'Character added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Character $character)
    {
//        $comics = $character->comics()->where('stock', '>', 0)->orderBy('stock', 'asc')->take(8)->get(); // comics with less stock without beaing 0

        //get the ids of the best sold comics
        $characterId = $character->id;

        $topComicIds = OrderItem::select('comic_id', DB::raw('SUM(quantity) as total_sold'))
            ->whereHas('comic.characters', function ($q) use ($characterId) {
                $q->where('characters.id', $characterId);
            })
            ->groupBy('comic_id')
            ->orderByDesc('total_sold')
            ->take(8)
            ->pluck('comic_id');

        $comics = Comic::whereIn('id', $topComicIds)
            ->get()
            ->sortBy(function ($comic) use ($topComicIds) {
                return array_search($comic->id, $topComicIds->toArray());
            });

        if ($comics->count() < 8) {
            $remaining = 8 - $comics->count();

            $fillerComics = Comic::whereHas('characters', function ($q) use ($characterId) {
                $q->where('characters.id', $characterId);
            })
                ->whereNotIn('id', $comics->pluck('id'))
                ->latest()
                ->take($remaining)
                ->get();

            $comics = $comics->concat($fillerComics);
        }


        return view('characters.show', compact('character', 'comics'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Character $character)
    {
        $publishers = Publisher::all();
        return view('characters.edit', compact('character', 'publishers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Character $character)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required','string','min:3','max:10000'],
            'publisher_id' => ['required','numeric','exists:publishers,id'],
            'first_appearance' => ['required','date','date_format:Y-m-d'],
        ]);

        $character->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'publisher_id' => $validatedData['publisher_id'],
            'first_appearance' => $validatedData['first_appearance'],
        ]);
        return redirect()->route('characters.edit', $character->id)->with('success', 'Character updated successfully');
    }

    public function updateImage(Request $request, Character $character){
        $validated = $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,gif', 'max:4096'],
        ]);

        if ($character->image && Storage::disk('public')->exists('characters/'.$character->image)) {
            Storage::disk('public')->delete('characters/'.$character->image);
        }

        $file = $request->file('image');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('characters', $filename, 'public');

        $character->update([
            'image' => $filename,
        ]);

        return redirect()->back()->with('success', 'Imagen del personaje actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Character $character)
    {

        if ($character->image && Storage::disk('public')->exists('characters/'.$character->image)) {
            Storage::disk('public')->delete('characters/'.$character->image);
        }
        $character->delete();
        return redirect()->route('characters.index')->with('success', 'Character deleted successfully');
    }
}
