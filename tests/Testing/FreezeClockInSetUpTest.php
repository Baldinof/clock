<?php

namespace Baldinof\Clock\Tests\Testing;

use Baldinof\Clock\Clock;
use Baldinof\Clock\SystemClock;
use Baldinof\Clock\Testing\FrozenClockTrait;
use PHPUnit\Framework\TestCase;

class FreezeClockInSetUpTest extends TestCase
{
    use FrozenClockTrait;

    protected function setUp(): void
    {
        $this->freezeClock(new \DateTimeImmutable("1987-03-21"));
    }

    public function test_it_is_frozen_by_setUp()
    {
        $frozen = new \DateTimeImmutable("1987-03-21");

        $this->assertEquals($frozen, Clock::now());
    }

    /**
     * @afterClass
     */
    public static function check_system_clock_is_restored(): void
    {
        self::assertInstanceOf(SystemClock::class, Clock::get());
    }
}
