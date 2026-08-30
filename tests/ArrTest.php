<?php

declare(strict_types=1);

namespace Astral\Utilities\Tests;

use Astral\Utilities\Arr;
use PHPUnit\Framework\TestCase;

final class ArrTest extends TestCase
{
    public function testOnly(): void
    {
        $input = ['a' => 1, 'b' => 2, 'c' => 3];
        $this->assertSame(['a' => 1, 'c' => 3], Arr::only($input, ['a', 'c']));
    }

    public function testExcept(): void
    {
        $input = ['a' => 1, 'b' => 2, 'c' => 3];
        $this->assertSame(['b' => 2], Arr::except($input, ['a', 'c']));
    }

    public function testFlatten(): void
    {
        $this->assertSame([1, 2, 3, 4], Arr::flatten([1, [2, [3, 4]]]));
    }

    public function testGet(): void
    {
        $data = ['user' => ['profile' => ['name' => 'Alice']]];
        $this->assertSame('Alice', Arr::get($data, 'user.profile.name'));
        $this->assertSame('n/a', Arr::get($data, 'user.missing', 'n/a'));
        $this->assertSame('Alice', Arr::get(['name' => 'Alice'], 'name'));
    }
}
