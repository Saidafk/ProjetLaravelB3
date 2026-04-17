# CineMap - Gestion d'emplacements de tournage

CineMap est une application Laravel permettant de gérer des lieux de tournage associés à des films. Ce projet est réalisé dans le cadre d'un TP Laravel (B3).

## 🚀 Installation

### Pré-requis
- PHP 8.2+
- Composer
- Node.js & NPM
- SQLite (ou autre base de données supportée par Laravel)

### Étapes d'installation
1. **Cloner le projet**
2. **Installer les dépendances** : `composer install` && `npm install`
3. **Environnement** : `cp .env.example .env` && `php artisan key:generate`
4. **Base de données** : `php artisan migrate:fresh --seed`
5. **Lancer le serveur** : `composer run dev`

---

## 🛠 Fonctionnalités implémentées (Étapes 1 à 8)

### ✅ Étape 1 à 5 : Socle, CRUDs, Admin, Jobs & Commandes
- **Auth & CRUDs** : Système complet pour Films et Locations.
- **Middleware Admin** : Protection des routes sensibles.
- **Jobs** : Recalcul asynchrone des upvotes.
- **Artisan** : Nettoyage automatique des lieux inactifs (`php artisan app:prune-inactive-locations`).

### ✅ Étape 6 : Qualité de code (Laravel Pint)
Le projet utilise **Laravel Pint** pour garantir un style de code propre et cohérent.

### ✅ Étape 7 : Connexion via Google (Socialite)
- **Social Auth** : Connexion rapide via Google Socialite.

### ✅ Étape 8 : Abonnement Stripe & API JWT
Seuls les utilisateurs Premium peuvent accéder aux données via l'API.
- **Paiement** : Intégration de Stripe Checkout.
- **Sécurité** : Authentification de l'API via tokens JWT.
- **Accès** : Middleware dédié pour vérifier l'abonnement actif.

---

## 📈 Roadmap (Dernière étape)
- [ ] **Étape 9** : Serveur MCP pour intégration IA.

---

## 📖 Documentation détaillée
Consultez le fichier [IMPLEMENTATION.md](./IMPLEMENTATION.md) pour retrouver l'emplacement exact du code et les détails techniques de chaque étape.
