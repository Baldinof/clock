<?php

namespace Baldinof\Clock\Tests;

use Baldinof\Clock\Clock;
use Baldinof\Clock\Testing\FrozenClock;
use DateTimeImmutable;
use DateTimeZone;
use PHPUnit\Framework\TestCase;

class ClockTest extends TestCase
{
    public function test_it_uses_the_php_timezone_by_default()
    {
        $baseDefaultTimezone = date_default_timezone_get();

        $now = Clock::now();

        $this->assertEquals(new DateTimeZone($baseDefaultTimezone), $now->getTimezone());

        date_default_timezone_set('UTC');

        $this->assertEquals(new DateTimeZone('UTC'), Clock::now()->getTimezone());

        date_default_timezone_set($baseDefaultTimezone);
    }

    public function test_it_supports_default_clock_overrides()
    {
        Clock::set($frozen = new FrozenClock(new DateTimeImmutable()));

        $this->assertSame($frozen, Clock::get());
    }

    protected function tearDown(): void
    {
        Clock::set(null);
    }
}
