# 💳 Guide Étape 8 : Stripe & API JWT (Sans JS)

Ce guide contient tout le code nécessaire pour finaliser l'étape 8 en mode "ultra-simple".

---

## 🛠 1. Préparation (Commandes à lancer)
Ouvre ton terminal et lance ces commandes :
```bash
# 1. Installer le système d'API de Laravel 11
php artisan install:api

# 2. Installer le package JWT
composer require php-open-source-saver/jwt-auth

# 3. Publier la config JWT et générer la clé secrète
php artisan vendor:publish --provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider"
php artisan jwt:secret
```

---

## 💰 2. Partie STRIPE (Paiement sans JS)

### A. Configurer le `.env`
Récupère tes clés sur ton dashboard Stripe (Mode Test) et ajoute-les :
```env
STRIPE_KEY=pk_test_...
STRIPE_SECRET=sk_test_...
STRIPE_WEBHOOK_SECRET=whsec_...
```

### B. Mettre à jour `app/Http/Controllers/StripeController.php`
```php
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
        // Remplace 'price_XXX' par ton ID de prix Stripe (ex: price_1P...)
        return $request->user()
            ->newSubscription('default', 'ID_DE_TON_PRIX_STRIPE')
            ->checkout([
                'success_url' => route('dashboard') . '?success=1',
                'cancel_url' => route('stripe.index') . '?error=1',
            ]);
    }
}
```

### C. Mettre à jour `resources/views/stripe/stripe.blade.php`
```html
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Abonnement Premium</h2>
    </x-slot>

    <div class="py-12 text-center">
        @if(auth()->user()->subscribed('default'))
            <p class="text-green-600 font-bold text-xl">Vous êtes actuellement abonné !</p>
        @else
            <p class="mb-4">Accédez à l'API exclusive en vous abonnant.</p>
            <form action="{{ route('stripe.subscribe') }}" method="POST">
                @csrf
                <x-primary-button>S'abonner (9.99€/mois)</x-primary-button>
            </form>
        @endif
    </div>
</x-app-layout>
```

---

## 🔑 3. Partie API JWT

### A. Modifier `app/Models/User.php`
Ajoute l'interface et les deux méthodes requises :
```php
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject; // <--- AJOUTER ÇA

class User extends Authenticatable implements JWTSubject // <--- AJOUTER L'INTERFACE
{
    // ... reste du code ...

    // AJOUTER CES DEUX MÉTHODES :
    public function getJWTIdentifier() { return $this->getKey(); }
    public function getJWTCustomClaims() { return []; }
}
```

### B. Configurer l'auth API dans `config/auth.php`
Cherche la section `guards` et modifie l'API :
```php
'guards' => [
    // ...
    'api' => [
        'driver' => 'jwt',
        'provider' => 'users',
    ],
],
```

### C. Créer le Middleware d'abonnement
Lance : `php artisan make:middleware CheckSubscription`
Dans `app/Http/Middleware/CheckSubscription.php` :
```php
public function handle($request, $next)
{
    if (!$request->user() || !$request->user()->subscribed('default')) {
        return response()->json(['error' => 'Abonnement requis pour accéder à cette ressource.'], 403);
    }
    return $next($request);
}
```

### D. Configurer les routes dans `routes/api.php`
```php
<?php

use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckSubscription;

// 1. Route pour obtenir le Token (Login API)
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    if (!$token = auth('api')->attempt($credentials)) {
        return response()->json(['error' => 'Identifiants invalides'], 401);
    }
    return response()->json(['token' => $token]);
});

// 2. Route protégée par JWT ET par l'Abonnement
Route::get('/films/{film}/locations', function (Film $film) {
    return response()->json([
        'film' => $film->title,
        'synopsis' => $film->synopsis,
        'locations' => $film->locations()->withCount('upvotes')->get()
    ]);
})->middleware(['auth:api', CheckSubscription::class]);
```

---

## 🧪 4. Comment tester ?

1.  **Paiement** : Va sur `/stripe`, clique sur le bouton, paie avec la carte de test `4242...`.
2.  **Obtenir le Token** : Utilise Postman (ou `curl`) sur `POST /api/login` avec ton email et mot de passe. Récupère le `token`.
3.  **Appel API** : Utilise Postman sur `GET /api/films/1/locations`. 
    - Ajoute un Header : `Authorization: Bearer <TON_TOKEN>`.
    - Si tu es abonné, tu vois le JSON. Sinon, tu reçois une erreur 403.
