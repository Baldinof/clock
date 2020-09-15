<?php

namespace Baldinof\Clock\Tests\Testing;

use Baldinof\Clock\Testing\FrozenClock;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class FrozenClockTest extends TestCase
{
    public function test_it_works()
    {
        $now = new DateTimeImmutable();

        $clock = new FrozenClock($now);
        $this->assertSame($now, $clock->now());
    }
}
