<?php

namespace Baldinof\Clock\Tests\Testing;

use Baldinof\Clock\Clock;
use Baldinof\Clock\Testing\FrozenClock;
use Baldinof\Clock\Testing\FrozenClockTrait;
use PHPUnit\Framework\TestCase;

class FrozenClockTraitTest extends TestCase
{
    use FrozenClockTrait;

    public function test_it_modify_time()
    {
        $now = Clock::now();

        $this->modifyClock("+5sec");

        $later = Clock::now();

        $diff = $later->getTimestamp() - $now->getTimestamp();

        $this->assertGreaterThan(4, $diff);
        $this->assertLessThan(6, $diff);
    }

    public function test_modify_with_invalid_format()
    {
        $this->expectException(\LogicException::class);

        $this->modifyClock('invalid_format');
    }

    public function test_manually_freeze_clock()
    {
        $frozen = new \DateTimeImmutable("1987-03-21");

        $this->freezeClock($frozen);

        $this->assertSame($frozen, Clock::now());

        $this->restoreSystemClock();
    }

    public function test_the_clock_is_frozen()
    {
        $this->assertInstanceOf(FrozenClock::class, Clock::get());
    }
}
