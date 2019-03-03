[Home](index.md) | [Identifying](identifying.md) | [**Setting**](setting.md) | [Getting](getting.md) | [Aliasing](aliasing.md) | [Deprecating](deprecating.md) | [Logging](logging.md) | [Caching](caching.md)

# Setting services and settings

Use Gravity to set services and settings for yourself and others.

## Gravity directory

Like [Composer](https://getcomposer.org), Gravity thinks in terms of packages. In fact, Gravity relies heavily on Composer's default filesystem to find its files.

As a _package_ author, you'll define your services and settings in a `.gravity` directory located in your package's root directory:

```
/path/to/package
|-- .gravity
|-- composer.json
|-- ...
```

As a _project_ author, you'll define your services and settings in a `.gravity` directory as well, and when you includes other packages using Composer, your filesystem will look something like this:

```
/path/to/project
|-- .gravity
|   |-- foo.php              # services and settings for your project
|-- composer.json
|-- src
|   |-- ...
|-- test
|   |-- ...
|-- vendor
|   |-- vendor1
|   |   |-- package1
|   |   |   |-- .gravity
|   |   |   |   |-- bar.php  # services and settings for package1
|   |   |   |-- ...
|   |   |-- package2
|   |   |   |-- .gravity
|   |   |   |   |-- baz.php  # services and settings for package2
|   |   |   |-- ...
|   |-- vendor2
|   |   |-- ...
|   |-- ...
|-- ...
```

A Gravity directory many contain any number of files and subdirectories, and any file in the directory will be considered a Gravity file.

## Gravity files

Within a Gravity file, the magic `$g` variable will always be defined ("g" is the common abbreviation for [gravity](https://en.wikipedia.org/wiki/Gravity_of_Earth)). You'll use `$g` and its methods to define services and settings:

```php
# /path/to/jstewmc/gravity/.gravity/examples/first.php

namespace Jstewmc\Gravity\Example\Service;

$g->set('jstewmc.gravity.example.foo', true);

$g->set(Foo::class, function (): Foo {
    return new Foo();
});
```

You can mix settings and services in the same file.

## Environments

Oftentimes, you'd like the _same_ setting to have _different_ values in _different_ environments. To that end, Gravity supports four environments:

* development
* test
* staging
* production

To detect its environment, Gravity looks for a `GRAVITY_ENV` environment variable. If it can't be found, Gravity will default to the development environment.

To define environment-specific services and settings, add an `environments` directory beneath your `.gravity` directory.

```
/path/to/package
|-- .gravity
|   |-- environments
|-- composer.json
|-- ...
```

Within the `environments` directory, you can use files named after an environment:

```
/path/to/package
|-- .gravity
|   |-- environments
|   |   |-- development.php
|   |   |-- test.php
|   |   |-- staging.php
|   |   |-- production.php
|-- composer.json
|-- ...
```

Or, you can define multiple files in directories named after an environment:

```
/path/to/package
|-- .gravity
|   |-- environments
|   |   |-- development
|   |   |   |-- foo.php
|   |   |   |-- bar.php
|   |   |-- test
|   |   |   |-- foo.php
|   |   |   |-- bar.php
|   |   |-- staging
|   |   |   |-- foo.php
|   |   |   |-- bar.php
|   |   |-- production
|   |   |   |-- foo.php
|   |   |   |-- bar.php
|-- composer.json
|-- ...
```

Keep in mind, environment files are not required, and they may be sparse. You can define as many (or as few) as you'd like.

Don't mix methods! If both a directory and file exist (e.g., `environments\development` and `environments\development.php`, respectively), the file will win.

## Precedence

When multiple definitions exist for the same service or setting, the last one wins.

Gravity loads files in the following order:

1. Package global files
2. Project global files
3. Package environment files
4. Project environment files

This way, _project_ definitions take precedence over _package_ definitions, and _local_ definitions take precedence over _global_ definitions. 

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

When a newable service is requested, Gravity will instantiate an instance of the class with the same name as the identifier and return it.

Be careful: case matters! Because you can't control the case sensitivity of your user's systems, you should assume they are _case sensitive_ and use the filesystem's case in the service name. Otherwise, Gravity (through Composer) won't be able to autoload the class. Don't worry, though. Getting the service is still _case insensitive_.

### Instances

An instance-defined service is already instantiated.

```php
# /path/to/jstewmc/gravity/.gravity/examples/setting.php

namespace Jstewmc\Gravity\Example;

$g->set(Setting\Qux::class, new Service\Qux());
```

When an instance-defined service is requested, Gravity will simply return the instance.

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
use Jstewmc\Gravity\Manager;
use Jstewmc\Gravity\Factory as FactoryInterface;

class Grault implements FactoryInterface
{
    public function __invoke(Manager $g): GraultService
    {
        return new GraultService();
    }
}

```

The Gravity file:

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

Configuration settings are just as important as services, because they allow _different_ users to use the _same_ code _different_ ways. Gravity's support for cross-definitions encourages this. You can build services that your users can configure.

Plus, configuration changes are much easier than code changes.

If you find yourself adding a constant, string, or number to your code, you should probably add it as a configuration setting instead!

Use the `$g->set()` method to define configuration settings. You can use any valid PHP value.

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

### Organization

You can organize your configuration settings however you'd like. By convention and for easier reading, identifiers should be lowercased (although, they're case-insensitive), and keys with multiple words should be hyphen-separated.

```php
// bad
$g->set('Harder.To.Read.Identifier');
$g->set('HARDER.TO.READ.IDENTIFIER');
$g->set('harder.to.read.identifier_with_multiword_keys');
$g->set('harder.to.read.identifierWithMultiwordKeys');

// good
$g->set('easier.to.read.identifier');
$g->set('easier.to.read.identifier-with-multiword-keys');
```

Also, if you find yourself adding prefixes to multiple, related keys, odds are those values should be grouped into an array.

```php
// bad
$g->set('jstewmc.gravity.example.waldo-one', 1);
$g->set('jstewmc.gravity.example.waldo-two', 2);
$g->set('jstewmc.gravity.example.waldo-three', 3);

// good
$g->set('jstewmc.gravity.example.waldo', [1, 2, 3]);
```

## Organization

Between the support for recursive directories, the mixing of services and configuration in the same file, and the support for environments, you're free to organize your package (or project) settings and services however you'd like.

Gravity allows _anyone_ to define settings and services _anywhere_. So, in your own Gravity files, you can define (or override) settings and services defined in another package. This allows authors to create services that users can configure.

Mixing definitions between packages can get confusing. Gravity logs important events like loading files, resolving paths, and more. By default, Gravity uses a null logger. However, you can inject any PSR-compliant logger. See [logging](logging.md) for details.

Leaving important services and settings to be defined can be risky. Gravity allows authors to define required services and settings using `$g->require()`, and it allows users to validate their project using the command line `gravity validate` tool. See [validating](validating.md) for details.

## That's it!

Next up, [getting services and setting](getting.md)!
