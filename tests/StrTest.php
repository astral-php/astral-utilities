<?php

declare(strict_types=1);

namespace Astral\Utilities\Tests;

use Astral\Utilities\Str;
use PHPUnit\Framework\TestCase;

final class StrTest extends TestCase
{
    public function testSlug(): void
    {
        $this->assertSame('hello-world', Str::slug('Hello World!'));
        $this->assertSame('cafe-creme', Str::slug('Café Crème'));
        $this->assertSame('a_b', Str::slug('A B', '_'));
    }

    public function testTruncate(): void
    {
        $this->assertSame('Hello…', Str::truncate('Hello World', 6));
        $this->assertSame('Hello World', Str::truncate('Hello World', 100));
    }

    public function testExcerpt(): void
    {
        $text = 'un deux trois quatre cinq six';
        $this->assertSame('un deux trois…', Str::excerpt($text, 3));
        $this->assertSame($text, Str::excerpt($text, 10));
    }

    public function testAscii(): void
    {
        $this->assertSame('Aeoeu', Str::ascii('Äéœü'));
    }
}
