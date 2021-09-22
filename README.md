# PHP Clock abstraction

[![Latest Version on Packagist](https://img.shields.io/packagist/v/baldinof/clock.svg?style=flat-square)](https://packagist.org/packages/baldinof/clock)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/baldinof/clock/Tests)](https://github.com/baldinof/clock/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/baldinof/clock.svg?style=flat-square)](https://packagist.org/packages/baldinof/clock)

Get current time in a static _and_ testable way.

## Installation

You can install the package via composer:

```bash
composer require baldinof/clock
```

## Static usage

```php
use Baldinof\Clock\Clock;

$now = Clock::now();

assert($now instanceof \DateTimeImmutable);
```

### Why static calls instead of dependency injection?

Static calls are very convenient when defining models:

```php
use Baldinof\Clock\Clock;
use Ramsey\Uuid\Uuid;

final class User
{
    private $id;
    private $createdAt;
    private $name;

    public function __construct(string $name)
    {
        $this->id = Uuid::uuid4();
        $this->createdAt = Clock::now();
        $this->name = $name;
    }

    // Getters...
}
```

## Testing

You can use the `FrozenClockTrait` in your test to freeze the clock a the begining of your tests and manipulate time.

```php
use Baldinof\Clock\Testing\FrozenClockTrait;
use Baldinof\Clock\Clock;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    use FrozenClockTrait;

    public function test_it_is_initialized_with_current_time()
    {
        $user = new User("John");

        $this->assertEquals(Clock::now(), $user->createdAt());
    }
}
```

You can allso explicitly manipulate the clock
```php
use Baldinof\Clock\Testing\FrozenClockTrait;
use Baldinof\Clock\Clock;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    use FrozenClockTrait;

    public function my_function()
    {
        // Set the clock at a specified time.
        $this->freezeClock(new \DateTimeImmutable('2000-01-01'));

        // Add an hour to the clock.
        $this->modifyClock('+1 h');

        // Reset the clock.
        $this->restoreSystemClock();
    }
}
```


## Timezones

Out of the box `Clock::now()` does not pass the timezone argument to the `DateTimeImmutable` constructor, so the **php default timezone is used.**

You can change the default timezone in your `php.ini`.

Otherwise, call `date_default_timezone_set()` or call `Clock::set()` in your application bootstrap code:

```php
<?php
use Baldinof\Clock\Clock;
use Baldinof\Clock\SystemClock;

// Change the clock implementation
Clock::set(SystemClock::forTimeZone('UTC'));
// or change the default timezone
date_default_timezone_set('UTC');
```

## Usage with dependency injection

You can get the actual clock instance and registers it in your dependency injection container by calling `Clock::get()`.

For example with Symfony PHP DSL:

```php
use Baldinof\Clock\Clock;
use Baldinof\Clock\ClockInterface;

return function (ContainerConfigurator $container) {
    $services = $container->services();
    $services
        ->set(ClockInterface::class)
        ->factory([Clock::class, 'get']);
};
```

Or with Laravel:

```php
// In a service provider
$this->app->instance(ClockInterface::class, Clock::get());
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

This package is inspired by [lcobucci/clock](https://github.com/lcobucci/clock) and [ramsey/uuid](https://github.com/ramsey/uuid) for the static usage.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
