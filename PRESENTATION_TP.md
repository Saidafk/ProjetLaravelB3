# Présentation du TP - Projet Laravel B3

Ce document sert de support pour l'explication orale du projet. Il détaille les choix techniques, les fonctionnalités implémentées et l'architecture globale.

---

## 1. Présentation Générale
Le projet est une plateforme de gestion de **Films** et de **Lieux de tournage (Locations)**. Il intègre un système d'authentification complet, une gestion des rôles (Admin), un système de paiement par abonnement (Stripe) et une interface de communication moderne via le protocole MCP.

## 2. Architecture Technique

### Stack Logicielle
- **Framework :** Laravel 11 (Structure moderne avec `bootstrap/app.php` et `routes/web.php`).
- **Base de données :** MySQL/SQLite (via Migrations).
- **Frontend :** Blade Templates + Tailwind CSS + Vite.
- **Authentification :** Laravel Breeze (Starter kit).

### Modèles de Données (Eloquent)
- **User :** Gère les utilisateurs, les droits "admin", l'intégration Stripe (Billable) et l'authentification Google.
- **Film :** Représente les œuvres cinématographiques (Titre, réalisateur, année, etc.).
- **Location :** Lieux associés aux films. 
    - *Relation :* Une Location appartient à un Film (BelongsTo).
    - *Système de Vote :* Intégration d'un système de "Upvotes".

## 3. Fonctionnalités Clés

### A. Gestion des Contenus (CRUD)
- Création, lecture, modification et suppression des Films et des Lieux.
- Validation stricte des données via les `Controller` (ex: `FilmController`, `LocationController`).

### B. Sécurité et Accès
- **Middleware Admin :** Protection des routes sensibles (création/suppression) pour que seul un administrateur puisse modifier la base.
- **Authentification Sociale :** Ajout de `google_id` dans la table `users` pour permettre la connexion via Google (Socialite).

### C. Système de Paiement (Stripe)
- Intégration de **Laravel Cashier**.
- **Middleware `CheckSubscription` :** Restreint l'accès à certaines parties du site (ex: voir les lieux de tournage exclusifs) aux utilisateurs ayant un abonnement actif.
- Gestion des factures et du portail client Stripe.

### D. Automatisation et Performance
- **Jobs (`RecalculateLocationUpvotes`) :** Traitement asynchrone pour recalculer les scores de popularité sans ralentir l'utilisateur.
- **Commands (`PruneInactiveLocations`) :** Tâche planifiée pour nettoyer automatiquement les données obsolètes.

## 4. L'Innovation : Le protocole MCP
Le projet inclut une implémentation du **Model Context Protocol (MCP)**.
- **But :** Permettre à une IA ou à un outil externe d'interagir intelligemment avec la base de données Laravel.
- **Outils (`app/Mcp/Tools`) :** `DescribeTable`, `ExecuteQuery`, `ListTables`. Cela rend l'application "AI-Ready".

---

## 5. Explication du Code (Points à montrer au prof)

1.  **Les Migrations :** Montre comment tu as structuré tes tables, notamment l'ajout des colonnes Stripe et des clés étrangères.
2.  **Le Middleware :** Ouvre `app/Http/Middleware/AdminMiddleware.php` pour montrer comment tu interceptes les requêtes.
3.  **La Relation Eloquent :** Dans le modèle `Location.php`, montre la méthode `film()`.
4.  **Le Job :** Explique que tu utilises les files d'attente (Queues) pour la performance.

---

## 6. Questions potentielles du jury / prof

- **Q : Pourquoi avoir utilisé un Job pour les votes ?**
  - *R : Pour ne pas bloquer l'utilisateur. Si le calcul est complexe ou s'il y a beaucoup de données, le faire en arrière-plan améliore l'expérience utilisateur (UX).*
- **Q : Comment as-tu sécurisé les routes ?**
  - *R : Via le fichier `routes/web.php` en utilisant les groupes de routes (`Route::middleware(['auth', 'admin'])`).*
- **Q : Comment gères-tu les erreurs de paiement ?**
  - *R : Cashier gère les exceptions Stripe, et j'utilise des webhooks (ou le middleware) pour vérifier l'état de l'abonnement en temps réel.*
- **Q : C'est quoi le dossier `Mcp` ?**
  - *R : C'est une interface standardisée pour que des agents externes puissent comprendre la structure de ma base de données sans accès direct SSH, en passant par des outils définis.*

---
*Document généré pour l'oral du 24/04/2026.*
