<?php

namespace Baldinof\Clock\Testing;

use Baldinof\Clock\Clock;
use Baldinof\Clock\ClockInterface;
use DateTimeImmutable;
use LogicException;

/**
 * Automatically freeze and restore clock in PHPUnit test cases
 */
trait FrozenClockTrait
{
    private ?ClockInterface $originalClock = null;

    /**
     * @before
     */
    public function freezeClock(?DateTimeImmutable $now = null): void
    {
        if (!$this->originalClock) {
            $this->originalClock = Clock::get();
        }

        Clock::set(new FrozenClock($now ?? new DateTimeImmutable()));
    }

    public function modifyClock(string $timespec): void
    {
        $new = @Clock::now()->modify($timespec);

        if ($new === false) {
            throw new LogicException(error_get_last()['message']);
        }

        Clock::set(new FrozenClock($new));
    }

    /**
     * @after
     */
    public function restoreSystemClock()
    {
        Clock::set($this->originalClock);
    }
}
