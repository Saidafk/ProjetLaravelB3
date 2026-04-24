# Documentation MCP — CineMap

## Qu'est-ce que MCP ?

MCP (Model Context Protocol) est un protocole standardisé qui permet à une IA (ex. GitHub Copilot, Claude, ChatGPT) d'interroger une application via des **outils** (tools) JSON-RPC.

Dans CineMap, le serveur MCP expose des outils en **lecture seule** pour permettre à une IA d'explorer la base de données.

---

## Architecture

```
VS Code / MCP Inspector
        │
        │  stdio (stdin/stdout)
        ▼
php artisan mcp:start laravel
        │
        ▼
App\Mcp\Servers\LaravelServer
        │
        ├── App\Mcp\Tools\ListTables
        ├── App\Mcp\Tools\DescribeTable
        └── App\Mcp\Tools\ExecuteQuery
```

### Fichiers du projet

| Fichier | Rôle |
|---|---|
| `routes/ai.php` | Enregistre le serveur avec `Mcp::local('laravel', LaravelServer::class)` |
| `app/Providers/AppServiceProvider.php` | Boot du service provider (import facade `Laravel\Mcp\Facades\Mcp`) |
| `app/Mcp/Servers/LaravelServer.php` | Déclare les outils dans `register()` |
| `app/Mcp/Tools/ListTables.php` | Outil : liste toutes les tables de la BDD |
| `app/Mcp/Tools/DescribeTable.php` | Outil : décrit les colonnes d'une table |
| `app/Mcp/Tools/ExecuteQuery.php` | Outil : exécute une requête SELECT en lecture seule |
| `.vscode/mcp.json` | Config VS Code pour démarrage automatique du serveur local |

---

## Démarrage

### Automatique (VS Code)

Le serveur se lance automatiquement via `.vscode/mcp.json` quand VS Code détecte la config MCP.

```jsonc
// .vscode/mcp.json
{
    "servers": {
        "laravel": {
            "type": "stdio",
            "command": "C:/WEB/php/php.exe",
            "args": [
                "C:/dev/ProjetLaravelB3/artisan",
                "mcp:start",
                "laravel"
            ],
            "cwd": "C:/dev/ProjetLaravelB3"
        }
    }
}
```

### Manuel (terminal)

```bash
php artisan mcp:start laravel
```

---

## Outils disponibles

### `list-tables`

Liste toutes les tables présentes dans la base de données.

- **Paramètres :** aucun
- **Exemple de réponse :**
```json
["users", "films", "locations", "location_votes", "subscriptions", ...]
```

---

### `describe-table`

Retourne la liste des colonnes et leurs types pour une table donnée.

- **Paramètre :** `table` (string, obligatoire) — nom de la table
- **Exemple d'appel :** `table = "locations"`
- **Exemple de réponse :**
```json
[
  { "name": "id", "type": "integer" },
  { "name": "film_id", "type": "integer" },
  { "name": "user_id", "type": "integer" },
  { "name": "name", "type": "string" },
  { "name": "city", "type": "string" },
  { "name": "country", "type": "string" },
  { "name": "upvotes_count", "type": "integer" }
]
```

---

### `execute-query`

Exécute une requête SQL en **lecture seule** (SELECT uniquement).

- **Paramètre :** `sql` (string, obligatoire) — requête SELECT
- **Exemple d'appel :** `sql = "SELECT id, name, city FROM locations LIMIT 5"`
- **Exemple de réponse :**
```json
[
  { "id": 1, "name": "Tour Eiffel", "city": "Paris" },
  { "id": 2, "name": "Colisée", "city": "Rome" }
]
```
- **Sécurité :** toute requête qui ne commence pas par `SELECT` est rejetée avec un message d'erreur.

---

## Tester avec MCP Inspector

### Lancer MCP Inspector

```bash
npx @modelcontextprotocol/inspector
```

Ou accéder à [https://inspector.mcp.run](https://inspector.mcp.run)

### Configuration de la connexion

| Champ | Valeur |
|---|---|
| **Transport Type** | `STDIO` |
| **Command** | `C:/WEB/php/php.exe` _(adaptez au chemin de votre PHP)_ |
| **Arguments** | `C:\\dev\\ProjetLaravelB3\\artisan mcp:start laravel` |

> ⚠️ **Problème courant sur Windows** — le champ **Arguments** de MCP Inspector est un input texte brut.
> Si vous tapez `C:\dev\...\artisan`, les `\d`, `\P`, `\a` sont interprétés comme des séquences d'échappement et le chemin devient invalide (`C:devProjetLaravelB3artisan`).
>
> **Solution :** utilisez des doubles backslashes `\\` ou des slashes `/` dans ce champ :
> ```
> C:\\dev\\ProjetLaravelB3\\artisan mcp:start laravel
> ```
> ou
> ```
> C:/dev/ProjetLaravelB3/artisan mcp:start laravel
> ```
>
> **Note :** Ce problème ne concerne PAS `.vscode/mcp.json` — ce fichier fonctionne correctement avec `\\` ou `/` car il est lu comme du JSON.

### Étapes de test

1. Configurer les champs ci-dessus → cliquer **Connect**
2. Vérifier : `● Connected` et `Laravel MCP Server - Version 0.0.1` apparaissent
3. Aller dans l'onglet **Tools** → cliquer **List Tools**
4. Sélectionner un outil, remplir les paramètres si besoin → **Run Tool**

### Exemples de tests

| Outil | Paramètre | Valeur |
|---|---|---|
| `list-tables` | _(aucun)_ | → cliquer Run Tool |
| `describe-table` | `table` | `locations` |
| `describe-table` | `table` | `films` |
| `execute-query` | `sql` | `SELECT * FROM films LIMIT 5` |
| `execute-query` | `sql` | `SELECT id, name, city FROM locations WHERE country = 'France'` |
| `execute-query` | `sql` | `SELECT f.title, COUNT(l.id) as nb_lieux FROM films f LEFT JOIN locations l ON l.film_id = f.id GROUP BY f.id` |

---

## Requêtes SQL utiles pour tester

```sql
-- Tous les films
SELECT * FROM films;

-- Tous les lieux de tournage avec le film associé
SELECT l.name, l.city, l.country, f.title
FROM locations l
JOIN films f ON f.id = l.film_id
LIMIT 10;

-- Top lieux par upvotes
SELECT name, city, upvotes_count
FROM locations
ORDER BY upvotes_count DESC
LIMIT 5;

-- Lieux par film
SELECT * FROM locations WHERE film_id = 1;

-- Nombre de lieux par pays
SELECT country, COUNT(*) as total
FROM locations
GROUP BY country
ORDER BY total DESC;
```

---

## Protocole JSON-RPC (référence)

Le serveur MCP utilise le protocole JSON-RPC 2.0. Voici les méthodes disponibles :

| Méthode | Description |
|---|---|
| `initialize` | Handshake initial (géré automatiquement) |
| `tools/list` | Liste les outils disponibles |
| `tools/call` | Appelle un outil avec des paramètres |

### Exemple brut `tools/call`

```json
{
  "jsonrpc": "2.0",
  "id": "1",
  "method": "tools/call",
  "params": {
    "name": "execute-query",
    "input": {
      "sql": "SELECT * FROM films LIMIT 3"
    }
  }
}
```
