<?php

namespace Baldinof\Clock;

use DateTimeImmutable;

final class Clock
{
    private static ?ClockInterface $clock = null;

    public static function now(): DateTimeImmutable
    {
        return self::get()->now();
    }

    public static function get(): ClockInterface
    {
        if (self::$clock === null) {
            self::$clock = new SystemClock();
        }

        return self::$clock;
    }

    public static function set(?ClockInterface $clock): void
    {
        static::$clock = $clock;
    }
}
