<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class LocationController extends Controller
{

    public function index()
    {
        $locations = Location::all();
        return view('location.index', compact('locations'));
    }

    public function destroy(Location $location): RedirectResponse
    {
        $location->delete();

        return redirect()->route('location.index')->with('success', 'La location a été supprimée avec succès.');
    }
}
