# Setting services and settings

Use Gravity to set services and settings for yourself and others.

## Gravity directory

Like [Composer](https://getcomposer.org), Gravity thinks in terms of packages. In fact, Gravity relies heavily on Composer's default filesystem to find its files.

As a package author, you'll define your services and settings in a `.gravity` directory located in your package's root directory:

```
/path/to/package
 |-- .gravity
 |-- composer.json
 |-- ...
```

A Gravity directory many contain any number of files and subdirectories. Any file in the directory will be considered a Gravity file.

## Gravity files

Within a Gravity file, the magic `$g` variable will always be defined ("g" is the abbreviation for [gravity](https://en.wikipedia.org/wiki/Gravity_of_Earth)). Use `$g` and its methods to define services and settings:

```php
# /path/to/jstewmc/gravity/.gravity/examples/basic.php

namespace Jstewmc\Gravity\Example\Service;

$g->set('jstewmc.gravity.example.foo', true);

$g->set(Foo::class, function (): Foo {
    return new Foo();
});
```

You can mix settings and services in the same file.

## Organization

Between the support for recursive directories and the mixing of services and configuration in the same file, you're free to organize your package's settings and services however you'd like.

Also, and this is important, Gravity allows _anyone_ to define settings and services _anywhere_. So, in your own Gravity files, you can define (or override) settings and services defined in another package. This allows you to create services that your users can configure.

## Services

A service is usually a class that does one thing, and does it well, often exposing a single public `__invoke` method.

No matter how you define a service, you can define it in Gravity.

Use the `$g->set()` method to define a service using `null`, an object instance, an anonymous function, or a factory.

### Newables

A newable-defined service is the simplest definition. It's `null`! A newable service is a service with the same classname as its identifier.

```php
# /path/to/jstewmc/gravity/.gravity/examples/setting.php

namespace Jstewmc\Gravity\Example;

$g->set(Service\Baz::class);
```

When a newable service is requested, Gravity will instantiate an instance of the class with the same name as the service identifier and return it.

### Instances

An instance-defined service is already instantiated.

```php
# /path/to/jstewmc/gravity/.gravity/examples/setting.php

namespace Jstewmc\Gravity\Example;

$g->set(Setting\Qux::class, new Service\Qux());
```

When an instance-defined service is requested, Gravity will return the instance.

### Anonymous functions

An anonymous function (aka, "fx") definition must accept no arguments, and it must return an `object` when invoked. However, anything can happen in between.

```php
#/path/to/jstewmc/gravity/.gravity/examples/setting.php

namespace Jstewmc\Gravity\Example;

$g->set(Setting\Quux::class, function (): Quux {
    return new Quux();
});
```

Within an anonymous function, `$this` refers to the Gravity manager. So, it's easy to inject other services and settings.

```php
#/path/to/jstewmc/gravity/.gravity/examples/setting.php

namespace Jstewmc\Gravity\Example;

$g->set(Setting\Corge::class, function (): Service\Corge {
    $quux = $this->get(Setting\Quux::class);

    return new Corge($quux);
});
```

When an anonymous-function-defined service is requested, Gravity will invoke the function and return the function's return value.

### Factories

A factory is a service that instantiates another service. A factory must implement Gravity's `Factory` interface, and it must be defined in Gravity as a newable service:

```php
# /path/to/jstewmc/gravity/docs/examples/src/Factory/Grault.php

namespace Jstewmc\Gravity\Example\Factory;

use Jstewmc\Gravity\Example\Service\Grault as GraultService;
use Jstewmc\Gravity\{Manager, Factory as FactoryInterface};

class Grault implements FactoryInterface
{
    public function __invoke(Manager $g): GraultService
    {
        return new GraultService();
    }
}
```

And the Gravity file:

```php
# /path/to/jstewmc/gravity/.gravity/examples/setting.php
namespace Jstewmc\Gravity\Example;

// set the factory as a newable-defined service
$g->set(Factory\Grault::class);

// set the service as a factory-defined service
$g->set(Service\Grault::class, Factory\Grault::class);
```

When a factory-defined service is requested, Gravity will instantiate the factory; call the factory's `__invoke()` method; and, return the the method's return value.

## Settings

In addition to services, Gravity supports configuration settings.

A configuration setting is a value that a service uses to make decisions. It may be a list of state abbreviations; a list of disposable email domains; a default token length; or, anything you need.

Configuration is just as important as services, because it allows _different_ users to use the _same_ code _different_ ways. Gravity's support for cross-definitions encourages this. Plus, configuration changes are much easier than code changes.

If you find yourself adding a constant, string, or number to your code, you should probably add it as a configuration setting instead!

Use the `$g->set()` method to define configuration settings. You can use any valid PHP value as a setting.

```php
# /path/to/jstewmc/gravity/.gravity/examples/setting.php

$g->set('jstewmc.gravity.example.setting.foo', true);
$g->set('jstewmc.gravity.example.setting.bar', 1);
$g->set('jstewmc.gravity.example.setting.baz', 'hello');
$g->set('jstewmc.gravity.example.setting.qux', [1, 2, 3]);
```

When multiple definitions exist for a scalar value, the last one wins. In the example below, the final value of `'jstewmc.gravity.example.setting.quux'` would be `2`:

```php
# /path/to/jstewmc/gravity/.gravity/examples/setting.php

$g->set('jstewmc.gravity.example.setting.quux', 1);
$g->set('jstewmc.gravity.example.setting.quux', 2);
```

On the other hand, when multiple definitions exist for an array value, the values will be merged. In the example below, the final value of `'jstewmc.gravity.example.setting.quuz'` would be `["qux", "quux"]`:

```php
# /path/to/jstewmc/gravity/.gravity/examples/setting.php

$g->set('jstewmc.gravity.example.setting.quuz', ['corge']);
$g->set('jstewmc.gravity.example.setting.quuz', ['grault']);
```

Gravity standardizes identifiers and arrays of any length. So don't worry about it. The two configuration settings below are equivalent:

```php
$g->set('jstewmc.gravity.example.setting.corge', [
    'garply' => [
        'waldo' => [
            'fred' => 1
        ]
    ]
]);

$g->set('jstewmc.gravity.example.setting.corge.garply.waldo.fred', 1);

```

Putting it all together in an example:

```php
# /path/to/jstewmc/gravity/examples/setting.md

namespace Jstewmc\Gravity\Example\Service;

use Jstewmc\Gravity\Manager;

require_once realpath(__DIR__ . '/../vendor/autoload.php');

$g = new Manager();

$expected = 2;
$actual   = $g->get('jstewmc.gravity.example.setting.quux');

assert($expected == $actual);

$expected = ['corge', 'grault'];
$actual   = $g->get('jstewmc.gravity.example.setting.quuz');

assert($expected == $actual);

$expected = 1;
$actual   = $g->get('jstewmc.gravity.example.setting.corge.garply.waldo.fred');

assert($expected == $actual);
```

You can organize your configuration however you'd like. However, by convention, keys with multiple words should be lowercased and hyphen-separated, and if you find yourself adding prefixes to multiple keys, those values should probably be grouped into an array.

```php
// bad
$g->set('jstewmc.gravity.example.waldo-one', 1);
$g->set('jstewmc.gravity.example.waldo-two', 2);
$g->set('jstewmc.gravity.example.waldo-three', 3);

// good
$g->set('jstewmc.gravity.example.waldo', [1, 2, 3]);
```
