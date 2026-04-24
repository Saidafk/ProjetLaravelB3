<?php

namespace App\Http\Controllers;

use App\Jobs\RecalculateLocationUpvotes;
use App\Models\Film;
use App\Models\Location;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::all();

        return view('location.index', compact('locations'));
    }

    public function indexApi()
    {
        return response()->json(Location::all());
    }

    public function create()
    {
        $films = Film::all();

        return view('location.create', compact('films'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'film_id' => 'required|integer|exists:films,id',
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $user_id = Auth::id();
        $request->merge(['user_id' => $user_id]);

        Location::create($request->all());

        return redirect()->route('location.index')->with('success', 'La location a été créée avec succès.');
    }

    public function upvote(Location $location)
    {
        $userId = Auth::id();

        if (! $userId) {
            return redirect()->back()->with('error', 'Vous devez être connecté.');
        }

        try {
            DB::table('location_votes')->insert([
                'user_id' => $userId,
                'location_id' => $location->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (QueryException $e) {
            return redirect()->back()->with('info', 'Vous avez déjà voté.');
        }

        RecalculateLocationUpvotes::dispatch($location);

        return redirect()->back()->with('success', 'Merci pour votre vote.');
    }

    public function edit(Location $location): View
    {
        if (Auth::id() !== $location->user_id && ! Auth::user()->is_admin) {
            abort(403);
        }

        $films = Film::all();

        return view('location.edit', compact('location', 'films'));
    }

    public function update(Request $request, Location $location): RedirectResponse
    {
        $request->validate([
            'film_id' => 'required|integer|exists:films,id',
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        if (Auth::id() !== $location->user_id && ! Auth::user()->is_admin) {
            abort(403);
        }

        $location->update($request->all());

        return redirect()->route('location.index')->with('success', 'La location a été mise à jour avec succès.');
    }

    public function destroy(Location $location): RedirectResponse
    {
        if (Auth::id() !== $location->user_id && ! Auth::user()->is_admin) {
            abort(403);
        }

        $location->delete();

        return redirect()->route('location.index')->with('success', 'La location a été supprimée avec succès.');
    }
}
