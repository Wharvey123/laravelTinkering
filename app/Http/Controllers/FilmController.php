<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $films = Film::all();
        return view('films.index', compact('films'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('films.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'director' => 'required|string|max:255',
            'year' => 'required|integer|min:1800|max:' . date('Y'),
            'description' => 'nullable|string',
        ]);

        Film::create($request->all());
        return redirect()->route('films.index')->with('success', 'Film created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $film = Film::findOrFail($id);
        return view('films.show', compact('film'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $film = Film::findOrFail($id);
        return view('films.edit', compact('film'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'director' => 'required|string|max:255',
            'year' => 'required|integer|min:1800|max:' . date('Y'),
            'description' => 'nullable|string',
        ]);

        $film = Film::findOrFail($id);
        $film->update($request->all());
        return redirect()->route('films.index')->with('success', 'Film updated successfully.');
    }

    /**
     * Show the confirmation form for deleting the specified resource.
     */
    public function confirmDelete(string $id)
    {
        $film = Film::findOrFail($id);
        return view('films.delete', compact('film'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $film = Film::findOrFail($id);

        // Protegir contra CSRF i assegurar-se que és una petició DELETE
        if ($request->isMethod('delete')) {
            $film->delete();
            return redirect()->route('films.index')->with('success', 'Film deleted successfully.');
        }

        return redirect()->route('films.index')->with('error', 'Invalid delete request.');
    }
}
