<?php

declare(strict_types=1);

namespace Astral\Utilities\Tests;

use Astral\Utilities\Date;
use DateTimeImmutable;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class DateTest extends TestCase
{
    public function testFormat(): void
    {
        $date = new DateTimeImmutable('2026-08-29 14:30:00');
        $this->assertSame('29/08/2026 14:30', Date::format($date));
        $this->assertSame('2026-08-29', Date::format('2026-08-29', 'Y-m-d'));
    }

    public function testDiffForHumansPast(): void
    {
        $now  = new DateTimeImmutable('2026-08-29 12:00:00');
        $past = new DateTimeImmutable('2026-08-26 12:00:00');

        $this->assertSame('il y a 3 jours', Date::diffForHumans($past, $now));
    }

    public function testDiffForHumansFuture(): void
    {
        $now    = new DateTimeImmutable('2026-08-29 12:00:00');
        $future = new DateTimeImmutable('2026-08-29 14:00:00');

        $this->assertSame('dans 2 heures', Date::diffForHumans($future, $now));
    }

    public function testInvalidDateThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Date::format('not-a-date');
    }
}
