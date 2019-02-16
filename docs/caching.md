[Home](index.md) | [Identifying](identifying.md) | [Setting](setting.md) | [Getting](getting.md) | [Aliasing](aliasing.md) | [Deprecating](deprecating.md) | [Logging](logging.md) | [**Caching**](caching.md)

# Caching

Gravity caches instantiated services and settings between calls.

By default, Gravity uses its own `Cache\Data\Hash` cache, a simple PHP array. However, you can use the `setCache` method to set your own cache before calling the `pull()` method:

```
namespace Jstewmc\Gravity;

// use your own $cache
$g = (new Gravity())->setCache($cache)->pull();

```

## PSR-16 compliance

Currently, our `Cache\Data\Cache` interface isn't [PSR-16](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-16-simple-cache.md) compliant. We don't need the `XMultiple()` methods, and we prefer to use the language's latest features like argument types, which the interface does not support. However, if you think this is a bad idea, [let us know](mailto:clayjs0@gmail.com)!
