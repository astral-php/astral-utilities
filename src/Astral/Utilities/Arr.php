<?php

declare(strict_types=1);

namespace Astral\Utilities;

/**
 * Helpers de tableaux — fonctions pures, zéro dépendance.
 */
final class Arr
{
    /**
     * Ne conserve que les clés listées.
     *
     * @param array<string|int, mixed> $array
     * @param list<string|int> $keys
     * @return array<string|int, mixed>
     */
    public static function only(array $array, array $keys): array
    {
        $result = [];
        foreach ($keys as $key) {
            if (array_key_exists($key, $array)) {
                $result[$key] = $array[$key];
            }
        }

        return $result;
    }

    /**
     * Retire les clés listées.
     *
     * @param array<string|int, mixed> $array
     * @param list<string|int> $keys
     * @return array<string|int, mixed>
     */
    public static function except(array $array, array $keys): array
    {
        foreach ($keys as $key) {
            unset($array[$key]);
        }

        return $array;
    }

    /**
     * Aplatit un tableau multidimensionnel (clés numériques séquentielles).
     *
     * @param array<mixed> $array
     * @return list<mixed>
     */
    public static function flatten(array $array): array
    {
        $result = [];

        array_walk_recursive($array, static function (mixed $value) use (&$result): void {
            $result[] = $value;
        });

        return $result;
    }

    /**
     * Accès par notation pointée (ex. user.profile.name).
     *
     * @param array<string|int, mixed> $array
     */
    public static function get(array $array, string $key, mixed $default = null): mixed
    {
        if ($key === '') {
            return $default;
        }

        if (array_key_exists($key, $array)) {
            return $array[$key];
        }

        if (!str_contains($key, '.')) {
            return $default;
        }

        $segments = explode('.', $key);
        $current  = $array;

        foreach ($segments as $segment) {
            if (!is_array($current) || !array_key_exists($segment, $current)) {
                return $default;
            }
            $current = $current[$segment];
        }

        return $current;
    }
}
