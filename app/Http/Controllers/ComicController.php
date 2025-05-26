<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Comic;
use App\Models\Publisher;
use Illuminate\Http\Request;

class ComicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( Request $request )
    {
        $query = Comic::query();

        if ($request->filled('search')) {
            $query->where('title','like', '%'.$request->search.'%');
        }

        if ($request->filled('publishers')) {
                $query->whereIn('publisher_id', $request->get('publishers'));
        }

        if ($request->filled('characters')) {
            $query->whereHas('characters', function ($q) use ($request) {
                $q->whereIn('characters.id', $request->get('characters'));
            });
        }

        if ($request->has('stock')) {
            $query->where('stock', '>', 0);
        }

        if ($request->filled('order_by')) {
            switch ($request->get('order_by')) {
                case 'price_asc';
                    $query->orderBy('price');
                    break;
                case 'price_desc';
                    $query->orderBy('price', 'desc');
                    break;
                case 'name_asc';
                    $query->orderBy('title');
                    break;
                case 'name_desc';
                    $query->orderBy('title', 'desc');
                    break;
                case 'new';
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        }

        $comics = $query->paginate(12)->onEachSide(1);
        $publishers = Publisher::all();
        $characters = Character::all();

        return view('comics.index', compact('comics', 'publishers', 'characters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Comic $comic)
    {
        $comic->load('ComicComments');
        $averageMark = round($comic->ComicComments()->avg('mark'),2);

        return view('comics.show', compact('comic', 'averageMark'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comic $comic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comic $comic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comic $comic)
    {
        //
    }
}
