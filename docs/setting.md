# Setting services and settings

As a _package author_ you'll use Gravity to _set_ services and settings for other developers to use.

## Gravity directory

Like [Composer](https://getcomposer.org), Gravity thinks in terms of packages. In fact, Gravity relies heavily on Composer's default filesystem to find its instructions.

As a package provider, you'll define your services and settings in a `.gravity` directory located in your package's root directory like `composer.json`:

```
/path/to/package
|-- .git
|-- .gravity   <----- here!
|-- src
|-- tests
|-- vendor
|-- .gitignore
|-- composer.json
|-- ...
```

A Gravity directory many contain any number of files and subdirectories. Any file in the directory is considered a Gravity file.

## Gravity files

Within a Gravity file, a "magic" `$g` variable is always defined ("g" is the abbreviation for [gravity](https://en.wikipedia.org/wiki/Standard_gravity). You'll use `$g` and its methods to define, alias, and deprecate services and settings):

```php
# /path/to/package/.gravity/foo.php
namespace Foo\Bar;

// define a setting
$g->set('foo.bar.baz', 1);

// define a service
$g->set(Baz::class, function () {
    return new Baz();
});
```

You can mix settings and services in the same file.

Between the support for recursive directories and the mixing of services and configuration in the same file, you're free to organize your package's settings and services however you'd like!

## Services

A service is typically a class that does one thing, and does it well, often exposing a single public `__invoke` method. However, no matter how you define a service, you can define it in Gravity.

You'll use the `$g->set()` method to define a service using `null`, an object instance, an anonymous function, or a factory.

### Newables

A newable is the simplest service definition. It's `null`! A newable service is a service with the same classname as its identifier.

```php
# /path/to/project/.gravity/stuff.php

namespace Foo\Bar;

$g->set(Baz::class);

```

### Instances

Instance-defined services are slightly more complicated than newables. An instance-defined service is already instantiated.

```php
# /path/to/project/.gravity/services.php

namespace Foo\Bar;

$g->set(Baz::class, new \StdClass());
```

### Anonymous functions

Anonymous functions are a simple and powerful way to define services.

An anonymous function must accept no arguments, and it must return an object when invoked. However, anything can happen in between.

Inside an anonymous function, `$this` refers to Gravity. So, it's easy to inject other services and configuration.

```php
#/path/to/project/.gravity/stuff.php

namespace Foo\Bar;

$g->set(Baz::class, function (): Foo {
    return new Baz();
});

$g->set(Qux::class, function (): Bar {
    $foo = $this->get(Baz::class);

    return new Qux($foo);
});
```

### Factories

If your service definition is too complex for an anonymous function, you can use a factory. A factory is a service that instantiates another service.

A factory must implement Gravity's Factory interface, and it must be defined in Gravity as a newable service.

When a factory-defined service is requested, its factory will be instantiated; the factory's `__invoke()` method will be called; and, it will be passed an instance of the Gravity manager.

The factory's `__invoke()` method must return an object, the service.

The factory:

```php
# /path/to/project/src/Factory/foo.php
namespace Foo\Bar\Factory;

use Foo\Bar\Service;
use Jstewmc\Gravity\{Manager, Factory};

class Baz implements Factory
{
    public function __invoke(Manager $g): Service\Baz
    {
        return new Service\Baz();
    }
}
```

The Gravity file:

```php
# /path/to/project/.gravity/stuff.php
namespace Foo\Bar\Service;

use Foo\Bar\Factory\Baz as BazFactory;

// define the factory as a newable-defined service
$g->set(BazFactory::class);  

// define the service as a factory-defined service
$g->set(Baz::class, BazFactory::class);  
```

## Settings

A configuration setting is a value that your package uses to make decisions. It may be a list of state abbreviations; a list of disposable email domains; a default token length; or, anything really.

Configuration is important because it allows _different_ people to use the _same_ code _different_ ways. Plus, configuration changes are always easier than code changes. If you find yourself adding a constant, string, or number to your code, you should probably add it as a configuration setting instead!

You'll use the `$g->set()` method to define configuration values using any valid PHP value.

```php
# /path/to/project/.gravity/config.php

$g->set('foo.bar.a', true);
$g->set('foo.bar.b', 1);
$g->set('foo.bar.c', 'hello');
$g->set('foo.bar.d', [1, 2, 3]);
$g->set('foo.bar.e', new StdClass());
```

When multiple definitions exist for a scalar value, the last one wins. On the other hand, when multiple definitions exist for an array value, the values will be merged.

```php
# /path/to/project/.gravity/config.php

$g->set('foo.bar.baz', 1);
$g->set('foo.bar.baz', 2);  // sets 'foo.bar.baz' to 2

$g->set('foo.bar.baz', ['qux']);
$g->set('foo.bar.baz', ['quux']);  // sets 'foo.bar.baz' to ['qux, quuz']
```
Gravity accepts identifiers and arrays of any length. So, don't worry about it:

```php
$g->set('foo.baz.baz.qux.quux.corge', [
    'grault' => [
        'garply' => [
            'waldo' => 1
        ]
    ]
]);
```

You can organize your configuration however you'd like. However, as a general rule of thumb, if you find yourself adding prefixes to multiple keys, those values should probably be grouped into an array:

```php
# /path/to/project/.gravity/config.php

// bad
$g->set('foo.bar.baz-a', 1);
$g->set('foo.bar.baz-b', 2);
$g->set('foo.bar.baz-c', 3);

// good
$g->set('foo.bar.baz', [1, 2, 3]);
```


## Aliases

Gravity supports aliases, although, in general, they are discouraged. It's a better world if every service is identified by a single identifier. However, sometimes aliases come in handy.

You can use the `$g->alias()` method to alias a setting or service. It accepts two identifiers: a source and a destination.

```php
# file /path/to/project/.gravity/stuff.php

namespace Jstewmc\Foo;

$g->set('foo.bar.baz', 1);

// alias setting 'foo.bar.qux' to 'foo.bar.baz'
$g->alias('foo.bar.qux', 'foo.bar.baz');  

$g->set(Foo::class, function () {
    return new Foo();
});

// alias service 'Jstewmc\Foo\Bar' to 'Jstewmc\Foo\Foo'
$g->alias(Bar::class, Foo::class);
```

Given the Gravity file above, the following conditionals would be true when [getting the settings and services](getting-services-and-settings.md):

```php
namespace Jstewmc\Gravity;

use Jstewmc\Foo\{Foo, Bar};

$g = new Manager();

$a = $g->get('foo.bar.baz');
$b = $g->get('foo.bar.qux');

$a == $b;  // returns true

$c = $g->get(Foo::class);
$d = $g->get(Bar::class);

$c === $d;  // returns true
```

## Deprecations

You shouldn't remove aliases, settings, or services without warning. Otherwise, you'll break your users code! Instead, you should deprecate your services and settings for at least a minor version of your package.

When a deprecated setting, service, or alias is requested, it's handled normally, except an `E_USER_DEPRECATED` error will be triggered. If a replacement has been given, the error's message will suggest it.

```php
# /path/to/project/.gravity/stuff.php
namespace Jstewmc\Foo;

$g->set('foo.bar.baz')

$g->set(Foo::class, function (): Foo {
    return Foo();
});

$g->set(Bar::class, function (): Bar {
    return Bar();
});

// deprecate the 'foo.bar.baz' setting
$g->deprecate('foo.bar.baz');

// deprecate the foo service without suggesting a replacement
$g->deprecate(Foo::class);

// deprecate the foo service with a replacement
$g->deprecate(Foo::class, Bar::class);
```

## Cross definitions

Gravity allows anyone to define settings and services anywhere. So, in your own Gravity files, you can define (or override) settings and services defined in another library. This allows for the maximum amount of customization.
