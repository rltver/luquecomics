<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use App\Models\OrderItem;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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

        return redirect()->route('publishers.create')->with('success', __('notifications.publisher_added'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Publisher $publisher)
    {
//        $comics = $publisher->comics()->where('stock', '>', 0)->orderBy('stock', 'asc')->take(8)->get(); // comics with less stock without beaing 0

        $publisherId = $publisher->id;

        $topComicIds = OrderItem::select('comic_id', DB::raw('SUM(quantity) as total_sold'))
            ->whereHas('comic.publisher', function ($q) use ($publisherId) {
                $q->where('publishers.id', $publisherId);
            })
            ->groupBy('comic_id')
            ->orderByDesc('total_sold')
            ->take(8)
            ->pluck('comic_id');

        $comics = Comic::whereIn('id', $topComicIds)
            ->where('stock','>',0)
            ->get()
            ->sortBy(function ($comic) use ($topComicIds) {
                return array_search($comic->id, $topComicIds->toArray());
            });

        if ($comics->count() < 8) {
            $remaining = 8 - $comics->count();

            $fillerComics = Comic::whereHas('publisher', function ($q) use ($publisherId) {
                $q->where('publishers.id', $publisherId);
            })
                ->whereNotIn('id', $comics->pluck('id'))
                ->where('stock','>',0)
                ->latest()
                ->take($remaining)
                ->get();

            $comics = $comics->concat($fillerComics);
        }


        return view('publishers.show', compact('publisher', 'comics'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Publisher $publisher)
    {
        return view('publishers.edit', compact('publisher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Publisher $publisher)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required','string','min:3','max:10000'],
            'creation_date' => ['required','date','date_format:Y-m-d'],
        ]);
        $publisher->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'creation_date' => $validatedData['creation_date'],
        ]);

        return redirect()->route('publishers.edit', $publisher->id)->with('success', __('notifications.publisher_updated'));

    }

    public function updateImage(Request $request, Publisher $publisher){
        $validated = $request->validate([
            'logo' => ['required', 'image', 'mimes:jpg,jpeg,png,gif', 'max:4096'],
        ]);

        if ($publisher->logo && Storage::disk('public')->exists('publishers/'.$publisher->logo)) {
            Storage::disk('public')->delete('publishers/'.$publisher->logo);
        }

        $file = $request->file('logo');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('publishers', $filename, 'public');

        $publisher->update([
            'logo' => $filename,
        ]);

        return redirect()->back()->with('success', __('notifications.publisher_image_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();
        return redirect()->route('home')->with('success', __('notifications.publisher_deleted'));
    }
}
