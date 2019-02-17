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

This library adheres to [PSR-16](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-16-simple-cache.md).
