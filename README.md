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
   ```bash
   git clone <url-du-repo>
   cd ProjetLaravelB3
   ```

2. **Installer les dépendances PHP et JS**
   ```bash
   composer install
   npm install
   npm run build
   ```

3. **Configuration de l'environnement**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Note : Configurez votre base de données dans le fichier `.env`.*

4. **Migrations et Seeders**
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Lancer le serveur**
   ```bash
   php artisan serve
   ```

---

## 🛠 Fonctionnalités implémentées (Étapes 1 à 5)

### 1. Authentification
- Système d'inscription, connexion et déconnexion.
- Accès restreint aux utilisateurs connectés pour la consultation des films et localisations.

### 2. CRUDs Métier
- **Films** : Liste, création, modification et suppression.
- **Locations** : Liste, création (avec choix du film), modification et suppression.
- *Note : Un emplacement est automatiquement rattaché à l'utilisateur qui le crée.*

### 3. Gestion des Droits (Middleware Admin)
- Un **Administrateur** (`is_admin = true`) peut modifier/supprimer tous les films et toutes les localisations.
- Un **Utilisateur standard** peut créer des localisations, mais ne peut modifier ou supprimer que ses propres créations.

### 4. Système de Votes (Queues & Jobs)
- Un utilisateur peut "Upvoter" un emplacement de tournage (limité à un vote par utilisateur par lieu).
- Le calcul du nombre total de votes est délégué à un **Job mis en file d'attente** (`RecalculateLocationUpvotes`).

**Pour tester les votes (Queue worker) :**
```bash
php artisan queue:work
```

### 5. Nettoyage Automatique (Commande Artisan)
- Commande personnalisée pour supprimer les lieux "inactifs".
- **Règle** : Supprime les emplacements créés il y a plus de 14 jours ayant moins de 2 upvotes.

**Pour tester la commande manuellement :**
```bash
php artisan app:prune-inactive-locations
```
*La commande est planifiée pour s'exécuter quotidiennement à 03:00.*

---

## 📈 Roadmap (Étapes suivantes)
- [ ] **Étape 6** : Intégration de Laravel Pint pour le formatage du code.
- [ ] **Étape 7** : Connexion via Socialite (OAuth).
- [ ] **Étape 8** : Système d'abonnement Stripe et API JSON (JWT).
- [ ] **Étape 9** : Serveur MCP pour intégration IA.

---

## 💻 Commandes utiles
- **Pint (Linting)** : `./vendor/bin/pint`
- **Tests** : `php artisan test`
