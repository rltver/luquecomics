<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Comic;
use App\Models\Publisher;
use Illuminate\Http\Request;

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

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Character $character)
    {
        $comics = $character->comics()->where('stock', '>', 0)->orderBy('stock', 'asc')->take(8)->get(); // comics with less stock without beaing 0

        return view('characters.show', compact('character', 'comics'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Character $characters)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Character $characters)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Character $characters)
    {
        //
    }
}
