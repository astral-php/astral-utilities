# astral-utilities

Helpers génériques pour [Astral MVC](https://github.com/astral-php/astral) — **zéro dépendance**.

Classes pures, testables, utilisables avec ou sans ServiceProvider.

[![PHP](https://img.shields.io/badge/PHP-8.1%E2%80%938.5-777BB4?logo=php&logoColor=white)](https://www.php.net)
[![Version](https://img.shields.io/badge/version-0.2.0-blue)](./CHANGELOG.md)

## Compatibilité

- PHP: `^8.1` (8.1 → 8.5)
- Astral MVC: `^1.1` (recommandé ≥ 1.1.3) pour le ServiceProvider optionnel

## Installation

```bash
composer require astral-php/astral-utilities
```

### Usage sans provider (recommandé)

```php
use Astral\Utilities\Str;
use Astral\Utilities\Date;
use Astral\Utilities\Arr;

Str::slug('Café Astral');           // cafe-astral
Str::truncate($text, 80);
Str::excerpt($text, 30);

Date::format('2026-08-29 14:00');   // 29/08/2026 14:00
Date::diffForHumans($createdAt);    // il y a 3 jours

Arr::only($data, ['id', 'name']);
Arr::except($data, ['password']);
Arr::get($data, 'user.email');
Arr::flatten($nested);
```

### ServiceProvider optionnel

Dans `config/dependencies.php` :

```php
use Astral\Utilities\UtilitiesServiceProvider;

return [
    // …
    UtilitiesServiceProvider::class,
];
```

Partage dans les vues : `$str`, `$date`, `$arr` (noms de classes pour appels statiques, ex. `$str::slug('…')`).

## API

### `Str`

| Méthode | Rôle |
|---------|------|
| `slug($value, $separator = '-')` | Slug URL ASCII |
| `truncate($value, $limit = 100, $end = '…')` | Coupe en caractères |
| `excerpt($value, $limit = 30, $end = '…')` | Coupe en mots |
| `limit(...)` | Alias de `truncate` |
| `ascii($value)` | Translittération accents courants |

### `Date`

| Méthode | Rôle |
|---------|------|
| `format($value, $format = 'd/m/Y H:i', $timezone = null)` | Formatage |
| `diffForHumans($value, $now = null, $timezone = null)` | Relatif FR |

### `Arr`

| Méthode | Rôle |
|---------|------|
| `only($array, $keys)` | Filtre par clés |
| `except($array, $keys)` | Exclut des clés |
| `flatten($array)` | Aplatit |
| `get($array, $key, $default = null)` | Notation pointée |

## Tests

```bash
composer install
composer test
```

## Licence

MIT
