<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Identifiants invalides'], 401);
        }

        return response()->json(['token' => $token]);
    }

    public function index()
    {
        return view('stripe.index');
    }

    public function subscribe(Request $request)
    {
        return $request->user()
            ->newSubscription('default', 'price_1TMr8SIY5qbYazxri8Nx6ipd')
            ->checkout([
                'success_url' => route('dashboard').'?success=1',
                'cancel_url' => route('stripe.index').'?error=1',
            ]);
    }

    public function unsubscribe(Request $request)
    {
        $request->user()->subscription('default')->cancelNow();

        return redirect()->route('stripe.index')->with('success', 'Vous avez été désabonné avec succès.');
    }
}
