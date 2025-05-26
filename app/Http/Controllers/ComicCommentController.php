<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use App\Models\ComicComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComicCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request,Comic $comic)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
            'mark' => 'required|integer|min:1|max:5'
        ]);
        $comic->ComicComments()->create([
            'content'=>$request->comment,
            'user_id' => Auth::id(),
            'mark' => $request->mark
        ]);

        return redirect()->back()->with('success', 'comment added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ComicComment $comic_comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ComicComment $comic_comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ComicComment $comic_comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ComicComment $comic_comment)
    {
        //
    }
}
