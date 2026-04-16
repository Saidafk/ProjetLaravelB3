# Guide d'Implémentation Technique - CineMap

Ce document détaille comment chaque étape du TP a été réalisée et où trouver le code source correspondant.

---

## 🔐 Étape 1 : Authentification
L'authentification a été mise en place via **Laravel Breeze** (Blade).

- **Controllers** : `app/Http/Controllers/Auth/`
- **Vues** : `resources/views/auth/`
- **Routes** : `routes/auth.php`
- **Logique** : Utilisation des fonctionnalités natives de Laravel pour l'inscription, la connexion et la gestion de session.

---

## 🎬 Étape 2 : CRUDs Métier (Film & Location)
Mise en place des modèles de données et des formulaires de gestion.

- **Modèles** :
    - `app/Models/Film.php` : Définit les champs `title`, `release_year`, `synopsis`.
    - `app/Models/Location.php` : Définit les champs `film_id`, `user_id`, `name`, `city`, `country`, `description`, `upvotes_count`.
- **Controllers** :
    - `app/Http/Controllers/FilmController.php`
    - `app/Http/Controllers/LocationController.php`
- **Relations Eloquent** :
    - `Film -> locations()` (HasMany)
    - `Location -> film()` (BelongsTo)
    - `Location -> user()` (BelongsTo)
- **Vues** : `resources/views/film/` et `resources/views/location/`

---

## 🛡 Étape 3 : Middleware Administrateur
Gestion des droits d'accès via un middleware personnalisé.

- **Migration** : `database/migrations/2026_04_16_000000_add_is_admin_to_users_table.php` (ajoute la colonne `is_admin`).
- **Middleware** : `app/Http/Middleware/AdminMiddleware.php` (vérifie si l'utilisateur est admin, sinon renvoie une 403).
- **Enregistrement** : Dans `bootstrap/app.php` sous l'alias `'admin'`.
- **Routes protégées** : `routes/web.php` utilise le groupe `middleware(['admin'])` pour les actions de modification/suppression globales.
- **Logique fine** : Dans `LocationController`, les méthodes `edit`, `update` et `destroy` vérifient manuellement si l'utilisateur possède l'objet OU est admin.

---

## ⚡ Étape 4 : Queues et Jobs (Upvotes)
Gestion asynchrone du calcul des votes pour améliorer les performances.

- **Migration** : `database/migrations/2026_04_16_100000_create_location_votes_table.php` (table pivot avec contrainte `unique(['user_id', 'location_id'])`).
- **Action de vote** : Méthode `upvote()` dans `LocationController.php`.
- **Job** : `app/Jobs/RecalculateLocationUpvotes.php`.
    - Ce job compte les entrées dans `location_votes` pour un lieu donné et met à jour le champ `upvotes_count` sur la table `locations`.
- **File d'attente** : Le job est dispatché via `RecalculateLocationUpvotes::dispatch($location)`.

---

## 📅 Étape 5 : Commande Artisan & Planification
Automatisation du nettoyage de la base de données.

- **Commande** : `app/Console/Commands/PruneInactiveLocations.php`.
    - **Règle** : Supprime les `locations` créées depuis plus de 14 jours avec moins de 2 upvotes.
- **Planification** : `routes/console.php`.
    - La commande est enregistrée dans le `Schedule` pour s'exécuter `dailyAt('03:00')`.

---

## 🎨 Étape 6 : Laravel Pint
Standardisation du style de code.

- **Outil** : `laravel/pint` (installé via Composer).
- **Configuration** : `composer.json` contient le script de lancement.
- **Application** : Tout le code a été formaté selon les standards PSR-12/Laravel.

---

## 🌐 Étape 7 : Connexion via Google (Socialite)
Intégration du Login Social.

- **Package** : `laravel/socialite`.
- **Migration** : `database/migrations/2026_04_16_150000_add_google_id_to_users_table.php`.
- **Controller** : `app/Http/Controllers/Auth/GoogleController.php`.
    - Gère la redirection vers Google et le callback.
    - Crée automatiquement l'utilisateur s'il n'existe pas ou lie le compte Google à un email existant.
- **Routes** : `routes/auth.php` (routes `/auth/google` et `/auth/google/callback`).
- **Vue** : `resources/views/auth/login.blade.php` (bouton d'accès rapide).
