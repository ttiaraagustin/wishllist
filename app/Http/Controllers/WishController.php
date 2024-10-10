<?php

namespace App\Http\Controllers;

use App\Models\Wish;
use Illuminate\Http\Request;

class WishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wishlist = Wish::orderBy('startline', 'DESC')->get();
        return view('pages.welcome', compact('wishlist'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Wish::create([
            'wish' => $request->wishName,
            'description' => $request->desc,
            'startline' => $request->start,
            'deadline' => $request->end,
            'status' => false,
        ]);

        return to_route('home');
    }

    /**
     * Display the specified resource.
     */
    public function show(Wish $wishlist)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wish $wish)
    {
        return view('pages.edit', compact('wishlist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $wishlist = Wish::find($id);
        $validation = $request->validate([
            'wish' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'startline',
            'deadline',
        ]);

        $wishlist->update($validation);
        return to_route('home');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $wishlist = Wish::find($id);
        $wishlist->delete();
        return back();
    }
}
