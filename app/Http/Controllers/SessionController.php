<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Comic;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create(){
        return view('auth.login');
    }

    public function store(Request $request){
        // validate
            $validated = request()->validate([
                'email' => ['required','email'],
                'password' => ['required'],
            ]);
        //attempt to log in
        if (!Auth::attempt($validated)){
            throw ValidationException::withMessages([
                'email' => ['Los credenciales no coinciden.'],
            ]);
        }
        //regenereta teh session token
        request()->session()->regenerate();
        //redirect
        return redirect()->intended();
    }

    public function destroy(){
        Auth::logout();
        return redirect('/');
    }

    public function orders(){
        return view('auth.orders');
    }

    public function accountInfo(){
        return view('auth.info');
    }

    public function addComic(Request $request){
        $characters = Character::all();
        $publishers = Publisher::all();
        return view('auth.add-comic', compact('characters', 'publishers'));
    }
    public function storeComic(Request $request){
        $validated = request()->validate([
            'title' => ['required','string','max:255','min:3'],
            'author' => ['required','string','max:255','min:3'],
            'artist' => ['required','string','max:255','min:3'],
            'description' => ['required','string','min:3','max:10000'],
            'price' => ['required','numeric','min:1','max:10000'],
            'stock' => ['required','numeric','min:1','max:10000'],
            'thumbnail_image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'publisher_id' => ['required','numeric','exists:publishers,id'],
            'characters' => ['array'],
            'characters.*' => ['exists:characters,id'],
            'type' => ['required', 'in:Trade paperback,Omnibus,Hard cover'],
            'pages' => ['required','numeric','min:1','max:10000'],
            'weight' => ['required','numeric','min:1','max:10000'],
        ]);

        $path = $request->file('thumbnail_image')->store('comics', 'public');

        $comic = Comic::create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'artist' => $validated['artist'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'thumbnail_image' => basename($path),
            'publisher_id' => $validated['publisher_id'],
            'type' => $validated['type'],
            'pages' => $validated['pages'],
            'weight' => $validated['weight'],
            'slug' => Str::slug($validated['title']).uniqid(),
        ]);

        $comic->characters()->sync($request->input('characters', []));

        return redirect()->route('session.addComic')->with('success', __('notifications.comic_added'));
    }

    public function deleteComic(Comic $comic){
        $comic->characters()->detach();
        $comic->delete();
        return redirect()->route('comics.index')->with('success', __('notifications.comic_deleted'));
    }

    public function editComic(Comic $comic){
        $characters = Character::all();
        $publishers = Publisher::all();
        return view('auth.edit-comic', compact('comic', 'characters', 'publishers'));
    }

    public function updateComic(Request $request, Comic $comic){
        $validated = request()->validate([
            'title' => ['required','string','max:255','min:3'],
            'author' => ['required','string','max:255','min:3'],
            'artist' => ['required','string','max:255','min:3'],
            'description' => ['required','string','min:3','max:10000'],
            'price' => ['required','numeric','min:1','max:10000'],
            'stock' => ['required','numeric','min:1','max:10000'],
            'publisher_id' => ['required','numeric','exists:publishers,id'],
            'characters' => ['array'],
            'characters.*' => ['integer','exists:characters,id'],
            'type' => ['required', 'in:Trade paperback,Omnibus,Hard cover'],
            'pages' => ['required','numeric','min:1','max:10000'],
            'weight' => ['required','numeric','min:1','max:10000'],
        ]);

        $comic->update([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'artist' => $validated['artist'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'publisher_id' => $validated['publisher_id'],
            'type' => $validated['type'],
            'pages' => $validated['pages'],
            'weight' => $validated['weight'],
            'slug' => Str::slug($validated['title']).uniqid(),
        ]);
        $comic->characters()->sync($request->input('characters', []));
        return redirect()->route('session.editComic', $comic->id)->with('success', __('notifications.comic_updated'));
    }

    public function updateThumbnail(Request $request, Comic $comic)
    {
        $validated = $request->validate([
            'thumbnail_image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        if ($comic->thumbnail_image && Storage::disk('public')->exists('comics/'.$comic->thumbnail_image)) {
            Storage::disk('public')->delete('comics/'.$comic->thumbnail_image);
        }

        $file = $request->file('thumbnail_image');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('comics', $filename, 'public');

        $comic->update([
            'thumbnail_image' => $filename,
        ]);

        return redirect()->back()->with('success', __('notifications.comic_thumbnail_updated'));
    }
}
