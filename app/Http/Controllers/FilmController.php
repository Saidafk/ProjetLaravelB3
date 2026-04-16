<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;

class FilmController extends Controller
{

    public function index()
    {
        $films = Film::all();
        return view('film.index', compact('films'));
    }

    public function create()
    {
        return view('film.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'synopsis' => 'required|string|max:255',
            'release_year' => 'required|integer',
        ]);

        Film::create($request->all());
        return redirect()->route('film.index')->with('success', 'Film créé !');
    }

    function edit(Film $film)
    {
        return view('film.edit', compact('film'));
    }

    public function update(Request $request, Film $film)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'synopsis' => 'required|string|max:255',
            'release_year' => 'required|integer',
        ]);

        $film->update($request->all());
        return redirect()->route('film.index')->with('success', 'Film mis à jour !');
    }

    public function destroy(Film $film)
    {
        $film->delete();
        return redirect()->route('film.index')->with('success', 'Film supprimé !');
    }
}