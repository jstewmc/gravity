[Home](index.md) | [Identifying](identifying.md) | [Setting](setting.md) | [Getting](getting.md) | [Aliasing](aliasing.md) | [**Deprecating**](deprecating.md)

## Deprecating services and settings

Deprecations allow you to mark aliases, settings, or services for removal without breaking your users' code. Deprecate them in one version and remove them in the next.

Use the `$g->deprecate()` method to deprecate an alias, setting, or service. The method accepts two arguments: a _deprecated id_ and an optional _replacement id_.

When a deprecated setting, service, or alias is requested, it's handled normally, except an `E_USER_DEPRECATED` error will be triggered. If a replacement has been given, it will be suggested in the error message.

```php
# /path/to/jstewmc/gravity/.gravity/deprecating.php

namespace Jstewmc\Gravity\Example;

// define settings to deprecate (use an array in real life)
$g->set('jstewmc.gravity.example.deprecating.foo', 0);
$g->set('jstewmc.gravity.example.deprecating.bar', 1);
$g->set('jstewmc.gravity.example.deprecating.baz', 2);

// define services to deprecate (using a fake namespace)
$g->set(Deprecating\Foo::class, function () {
    return new Service\Foo();
});

$g->set(Deprecating\Bar::class, function () {
    return new Service\Bar();
});

$g->set(Deprecating\Baz::class, function () {
    return new Service\Baz();
});

// deprecate a setting without replacement
$g->deprecate('jstewmc.gravity.example.deprecating.foo');

// deprecate a setting with a replacement
$g->deprecate(
    'jstewmc.gravity.example.deprecating.bar',
    'jstewmc.gravity.example.deprecating.baz'
);

// deprecate foo without a replacement
$g->deprecate(Deprecating\Foo::class);

// deprecate bar with a replacement
$g->deprecate(Deprecating\Bar::class, Deprecating\Baz::class);
```

Using the deprecations (this example will trigger `E_USER_DEPRECATED` errors):

```php
# /path/to/jstewmc/gravity/examples/deprecating.php

namespace Jstewmc\Gravity\Example;

use Jstewmc\Gravity\Manager;

require_once realpath(__DIR__ . '/../vendor/autoload.php');

$g = new Manager();

// without suggested replacement
$g->get('jstewmc.gravity.example.deprecating.foo');
$g->get(Deprecating\Foo::class);

// with suggested replacement
$g->get('jstewmc.gravity.example.deprecating.bar');
$g->get(Deprecating\Bar::class);
```

---

That's it! Return [home](index.md) or start [coding](https://github.com/jstewmc/gravity)!
