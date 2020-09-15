<?php

namespace Baldinof\Clock\Testing;

use Baldinof\Clock\ClockInterface;
use DateTimeImmutable;

final class FrozenClock implements ClockInterface
{
    private DateTimeImmutable $now;

    public function __construct(DateTimeImmutable $now)
    {
        $this->now = $now;
    }

    public function now(): DateTimeImmutable
    {
        return $this->now;
    }
}
