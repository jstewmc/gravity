[Home](index.md) | [Identifying](identifying.md) | [Setting](setting.md) | [Getting](getting.md) | [Aliasing](aliasing.md) | [Deprecating](deprecating.md) | [**Logging**](logging.md) | [Caching](caching.md)

# Logging

Gravity includes logging around key events like resolving paths, loading files, getting services, and getting settings.

By default, Gravity uses the `Psr\Log\NullLogger`, however, you can use any [PSR-3](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md) compliant logger you'd like.

Use Gravity's `setLogger()` method to set your own logger before calling the `pull()` method:

```
namespace Jstewmc\Gravity;

// assuming $logger is your $logger
$g = (new Gravity())->setLogger($logger)->pull();
```
