<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function index()
    {
        return view('stripe.index');
    }

    public function subscribe(Request $request)
    {
        return $request->user()
            ->newSubscription('default', 'prod_ULYEJlU0BQ6kjD')
            ->checkout([
                'success_url' => route('dashboard') . '?success=1',
                'cancel_url' => route('stripe.index') . '?error=1',
            ]);
    }
}