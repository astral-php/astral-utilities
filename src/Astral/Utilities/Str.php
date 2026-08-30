<?php

declare(strict_types=1);

namespace Astral\Utilities;

/**
 * Helpers de chaînes — fonctions pures, zéro dépendance.
 */
final class Str
{
    /**
     * Transforme une chaîne en slug URL (ASCII, tirets).
     */
    public static function slug(string $value, string $separator = '-'): string
    {
        $value = self::ascii($value);
        $value = strtolower($value);
        $value = preg_replace('/[^a-z0-9]+/', $separator, $value) ?? '';
        return trim($value, $separator);
    }

    /**
     * Tronque à $limit caractères (par défaut avec ellipsis).
     */
    public static function truncate(string $value, int $limit = 100, string $end = '…'): string
    {
        if ($limit < 0) {
            $limit = 0;
        }

        if (mb_strlen($value) <= $limit) {
            return $value;
        }

        $endLen = mb_strlen($end);
        if ($limit <= $endLen) {
            return mb_substr($end, 0, $limit);
        }

        return rtrim(mb_substr($value, 0, $limit - $endLen)) . $end;
    }

    /**
     * Extrait un aperçu sur $limit mots.
     */
    public static function excerpt(string $value, int $limit = 30, string $end = '…'): string
    {
        $value = trim(preg_replace('/\s+/u', ' ', $value) ?? $value);
        $words = preg_split('/\s+/u', $value, -1, PREG_SPLIT_NO_EMPTY) ?: [];

        if (count($words) <= $limit) {
            return $value;
        }

        return implode(' ', array_slice($words, 0, $limit)) . $end;
    }

    /**
     * Alias de truncate (limite de caractères).
     */
    public static function limit(string $value, int $limit = 100, string $end = '…'): string
    {
        return self::truncate($value, $limit, $end);
    }

    /**
     * Translittération ASCII simplifiée (accents courants).
     */
    public static function ascii(string $value): string
    {
        $map = [
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
            'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O',
            'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o',
            'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U',
            'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u',
            'Ý' => 'Y', 'ý' => 'y', 'ÿ' => 'y',
            'Ç' => 'C', 'ç' => 'c',
            'Ñ' => 'N', 'ñ' => 'n',
            'Æ' => 'AE', 'æ' => 'ae', 'Œ' => 'OE', 'œ' => 'oe',
            'ß' => 'ss',
        ];

        return strtr($value, $map);
    }
}
