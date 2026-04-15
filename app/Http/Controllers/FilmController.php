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

    public function destroy(Film $film)
    {
        $film->delete();
        return redirect()->route('film.index')->with('success', 'Film supprimé !');
    }
}