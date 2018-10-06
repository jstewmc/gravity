# Gravity

Gravity is a framework-agnostic service and configuration manager. Gravity makes it easy to use other people's settings and services in your application.

[![Build Status](https://travis-ci.com/jstewmc/gravity.svg?branch=master)](https://travis-ci.com/jstewmc/gravity) [![codecov](https://codecov.io/gh/jstewmc/gravity/branch/master/graph/badge.svg)](https://codecov.io/gh/jstewmc/gravity)

## Usage

Create a service:

```php
# /path/to/jstewmc/gravity/docs/examples/src/Service/Foo.php

namespace Jstewmc\Gravity\Example\Service;

class Foo
{
    public function __invoke(): string
    {
        return 'foo';
    }
}
```

Add your service (and any settings) to a Gravity file:

```php
# /path/to/jstewmc/gravity/.gravity/examples/basic.php

namespace Jstewmc\Gravity\Example\Service;

$g->set(Foo::class, function (): Foo {
    return new Foo();
});

$g->set('jstewmc.gravity.example.foo', true);
```

Use your service:

```php
# /path/to/jstemwc/gravity/examples/basic.php

namespace Jstewmc\Gravity\Example\Service;

use Jstewmc\Gravity\Manager;

require_once realpath(__DIR__ . '/../vendor/autoload.php');

$g = new Manager();

// Gravity returns an instance of Foo
assert($g->get(Foo::class) instanceof Foo);

// Gravity returns true
$expected = true;
$actual   = $g->get('jstewmc.gravity.example.foo');

assert($expected == $actual);
```

That's it!

Of course, this was just your work. Imagine getting and setting services and settings in _any package_! That's the power of Gravity. It just pulls everything together.

## Examples

You can run the example above (and most examples in the documentation), by cloning the repository, navigating to it on your filesystem, and using the PHP command line. Most examples use `assert()` statements, and will output nothing when successful, unless stated otherwise.

```bash
$ cd /path/to/jstewmc/gravity

/path/to/jstewmc/gravity$ php examples/basic.php
```

## Documentation

[Documentation](https://github.com/jstewmc/gravity/blob/master/docs/index.md) is available online or in the `docs` directory.

We strive to maintain great documentation. If you see a mistake or have a suggestion, feel free to fork it!

## Installation

Gravity requires [PHP 7.2+](https://secure.php.net).

Gravity is multi-platform, and we strive to make it run equally well on Windows, Linux, and OSX.

Gravity must be installed via [Composer](https://getcomposer.org). To do so, add the following line to the `require` section of your `composer.json` file (where `x` is the latest major version), and run `composer update`:

```javascript
{
   "require": {
       "jstewmc/gravity": "^x"
   }
}
```

## Compliance

This library strives to adhere to the following standards:

1. [Semantic Versioning 2.0](http://semver.org/spec/v2.0.0.html);
2. [Keep a Changelog 1.0](http://keepachangelog.com/en/1.0.0/);
3. [PSR-2](https://www.php-fig.org/psr/psr-2/); and,
4. [SODO Design Pattern 0.1.0](https://github.com/jstewmc/sodo-design-pattern).

If you spot an error, please let us know!

## License

This library is licensed under the [MIT license](LICENSE).

## Credits

This library was originally developed by [Jack Clayton](mailto:clayjs0@gmail.com) with input from my good friends like [Andy O'brien](https://github.com/javabudd) and [Harry Wallin](https://github.com/BillwoodMarbles).

We hope you enjoy it!
