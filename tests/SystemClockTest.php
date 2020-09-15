<?php

namespace Baldinof\Clock\Tests;

use Baldinof\Clock\SystemClock;
use DateTimeImmutable;
use DateTimeZone;
use PHPUnit\Framework\TestCase;

final class SystemClockTest extends TestCase
{
    public function test_it_get_current_time()
    {
        $utc = new DateTimeZone("UTC");

        $clock = new SystemClock($utc);

        $now = new DateTimeImmutable('now', $utc);

        $clockNow = $clock->now();

        $diff = $clockNow->getTimestamp() - $now->getTimestamp();

        $this->assertEquals($utc, $clockNow->getTimezone());
        $this->assertLessThanOrEqual(1, $diff);
    }

    public function test_timezone_constructor()
    {
        $regularConstructor = new SystemClock(new DateTimeZone("UTC"));
        $timezoneConstructor = SystemClock::forTimeZone("UTC") ;

        $this->assertEquals($regularConstructor, $timezoneConstructor);
    }
}
