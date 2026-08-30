<?php

declare(strict_types=1);

namespace Astral\Utilities;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use InvalidArgumentException;

/**
 * Helpers de dates — formats courants + diff relatif FR simplifié.
 */
final class Date
{
    /**
     * Formate une date (string parseable ou DateTimeInterface).
     */
    public static function format(
        string|DateTimeInterface $value,
        string $format = 'd/m/Y H:i',
        ?string $timezone = null,
    ): string {
        return self::toDateTime($value, $timezone)->format($format);
    }

    /**
     * Différence relative en français (ex. « il y a 3 jours »).
     */
    public static function diffForHumans(
        string|DateTimeInterface $value,
        string|DateTimeInterface|null $now = null,
        ?string $timezone = null,
    ): string {
        $date = self::toDateTime($value, $timezone);
        $ref  = $now === null
            ? new DateTimeImmutable('now', $timezone ? new DateTimeZone($timezone) : null)
            : self::toDateTime($now, $timezone);

        $seconds = $ref->getTimestamp() - $date->getTimestamp();
        $future  = $seconds < 0;
        $seconds = abs($seconds);

        $unit = match (true) {
            $seconds < 60 => [max(1, $seconds), 'seconde', 'secondes'],
            $seconds < 3600 => [(int) floor($seconds / 60), 'minute', 'minutes'],
            $seconds < 86400 => [(int) floor($seconds / 3600), 'heure', 'heures'],
            $seconds < 2592000 => [(int) floor($seconds / 86400), 'jour', 'jours'],
            $seconds < 31536000 => [(int) floor($seconds / 2592000), 'mois', 'mois'],
            default => [(int) floor($seconds / 31536000), 'an', 'ans'],
        };

        [$count, $singular, $plural] = $unit;
        $label = $count > 1 ? $plural : $singular;

        return $future
            ? "dans {$count} {$label}"
            : "il y a {$count} {$label}";
    }

    private static function toDateTime(
        string|DateTimeInterface $value,
        ?string $timezone = null,
    ): DateTimeImmutable {
        $tz = $timezone !== null ? new DateTimeZone($timezone) : null;

        if ($value instanceof DateTimeInterface) {
            $immutable = DateTimeImmutable::createFromInterface($value);
            return $tz !== null ? $immutable->setTimezone($tz) : $immutable;
        }

        try {
            return new DateTimeImmutable($value, $tz);
        } catch (\Exception $e) {
            throw new InvalidArgumentException('Date invalide : ' . $value, 0, $e);
        }
    }
}
