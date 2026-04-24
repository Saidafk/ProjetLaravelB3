# CineMap - Documentation Technique (TP B3)

Ce projet est une application Laravel 11 intégrant les fonctionnalités requises pour le TP B3.

## 🛠 Installation et Configuration

```bash
# 1. Installation des dépendances
composer install
npm install

# 2. Configuration environnement
cp .env.example .env
php artisan key:generate

# 3. Base de données (Migrations + Seeders)
php artisan migrate:fresh --seed

# 4. Configuration Sécurité (JWT)
php artisan jwt:secret

# 5. Lancement des serveurs
php artisan serve
npm run dev
```

---

## 🚀 Utilisation des fonctionnalités (9 Étapes)

### Étape 1 & 2 : Administration et Accès
L'administration est protégée par un middleware. Les accès se gèrent via l'interface web.
- **Accès Admin** : Se connecter avec un compte ayant `is_admin = 1`.

### Étape 3 : Maintenance des Lieux
Commande pour supprimer les lieux de tournage marqués comme inactifs.
```bash
php artisan app:prune-inactive-locations
```

### Étape 4 : Traitement des Votes (Jobs)
Les calculs de popularité sont délégués aux Workers.
```bash
php artisan queue:work
```

### Étape 5 : Paiements Stripe
Pour tester les abonnements en local, lancer le listener Stripe :
```bash
.\stripe listen --forward-to http://127.0.0.1:8000/stripe/webhook
```

### Étape 6 : Qualité de Code (Linter)
Formatage automatique du code selon les standards.
```bash
./vendor/bin/pint
```

### Étape 7 : Authentification Google
Configuration requise dans le `.env` (`GOOGLE_CLIENT_ID` et `GOOGLE_CLIENT_SECRET`).

### Étape 8 : API et Sécurité JWT
Génération du token via `/api/login` puis utilisation pour les endpoints sécurisés.
```bash
# Exemple d'appel API
curl -H "Authorization: Bearer <token>" http://127.0.0.1:8000/api/locations
```

### Étape 9 : Interface IA (Serveur MCP)
Lancer le serveur pour permettre à une IA d'interroger la base de données.
```bash
php artisan mcp:start laravel
```

---

## 🧪 Tests
```bash
php artisan test
```
