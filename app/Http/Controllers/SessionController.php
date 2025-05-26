<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Comic;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'price' => ['required','numeric','min:1'],
            'stock' => ['required','numeric','min:1'],
            'thumbnail_image' => ['required', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            'publisher_id' => ['required','numeric','exists:publishers,id'],
            'characters' => ['required','array'],
            'characters.*' => ['required','exists:characters,id'],
            'type' => ['required', 'in:Trade paperback,Omnibus,Hard cover'],
            'pages' => ['required','numeric','min:1'],
            'weight' => ['required','numeric','min:1'],
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
            'slug' => Str::slug($validated['title'])
        ]);

        $comic->characters()->sync($request->input('characters', []));

        return redirect()->route('session.addComic')->with('success', 'Comic added successfully');
    }

    public function deleteComic(Comic $comic){
        $comic->characters()->detach();
        $comic->delete();
        return redirect()->route('comics.index')->with('success', 'Comic deleted successfully');
    }
}
