[Home](index.md) | [Identifying](identifying.md) | [Setting](setting.md) | [**Getting**](getting.md) | [Aliasing](aliasing.md) | [Deprecating](deprecating.md) | [Logging](logging.md)

# Getting services and settings

Use Gravity to get services and settings from yourself or others.

## Gravity manager

To get a setting or service from Gravity you need an instance of the manager, often abbreviated `$g` (the abbreviation for [gravity](https://en.wikipedia.org/wiki/Gravity_of_Earth)).

When the Gravity manager is instantiated, it loads settings and services from the project filesystem. Sometimes, this may involve reading hundreds of files and thousands of settings and services. This is not an inexpensive operation!

For best performance, use a single instance of the Gravity manager as long as possible.

As a new library, Gravity doesn't have integrations for the major frameworks yet. Until it does, it's up to you to figure out how to keep Gravity around as long as possible in your application. But, if you have a good solution, open a pull request or [let us know](mailto:clayjs0@gmail.com)!

## Requests

Use the `$g->get()` method and its single argument, an identifier, to request services and settings.

The first time you request a service, Gravity will instantiate and return it. Unless the service is set again, Gravity will always return the cached value.

```php
# /path/to/jstewmc/gravity/examples/getting.php

namespace Jstewmc\Gravity\Example;

use Jstewmc\Gravity\Gravity;

require_once realpath(__DIR__ . '/../vendor/autoload.php');

$g = (new Gravity())->pull();

// using the settings from ../.gravity/examples/setting.php:31
$expected = true;
$actual   = $g->get('jstewmc.gravity.example.setting.foo');

assert($expected == $actual);

// using the settings from ../.gravity/examples/setting.php:12
$instance = $g->get(Setting\Qux::class);

assert($instance instanceof Service\Qux);

$a = $g->get(Setting\Qux::class);
$b = $g->get(Setting\Qux::class);

// remember, PHP's === operator compares the object's references in memory
assert($a === $b);
```

That's it. Getting services and settings is the easy part!

## That's it!

Next up, [aliasing services and setting](aliasing.md)!
