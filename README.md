[![Build Status](https://travis-ci.com/jstewmc/gravity.svg?branch=master)](https://travis-ci.com/jstewmc/gravity) [![codecov](https://codecov.io/gh/jstewmc/gravity/branch/master/graph/badge.svg)](https://codecov.io/gh/jstewmc/gravity)


# Gravity

Gravity is a framework-agnostic, community-friendly service and configuration manager.

Gravity makes it easy to use other people's settings and services in your application. As a _package author_, you'll use Gravity to _set_ settings and services. As a _package consumer_ you'll use Gravity to _get_ settings and services.

## Usage

Here's a simple example:

### Package authors

As a _package author_, you'll create a service:

```php
# /path/to/project/src/Baz.php
namespace Foo\Bar;

class Baz
{
    public function __invoke(): string
    {
        return 'baz';
    }
}
```

You'll define the service in a Gravity file:

```php
# /path/to/project/.gravity/services.php
namespace Foo\Bar;

$g->set(Baz::class, function (): object {
    return new Baz();
});
```

And, you'll add your (awesome) package to Packagist for others to use.

### Package consumers

As a _package consumer_, you'll add the `Foo\Bar` package (and Gravity) to your `composer.json` file.

Then, you'll use the `Baz` service in your application:

```php
# path/to/project/file.php
namespace Foo\Bar;

use Jstewmc\Gravity\Manager;
use Foo\Bar\Baz;

$g = new Manager();

$g->get(Baz::class)();
```

That's it!

## Documentation

Of course, there is much more that Gravity can do!

See [the documentation](https://github.com/jstewmc/gravity/blob/master/docs/getting-started.md) for details.

## Installation

Gravity requires [Composer](https://getcomposer.org) and [PHP 7.2+](https://secure.php.net).

Gravity is multi-platform, and we strive to make it run equally well on Windows, Linux, and OSX.

To install Gravity, add the following line to the `require` section of your `composer.json` file (where `x` is the latest major version):

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

This library was originally developed by [Jack Clayton](mailto:clayjs0@gmail.com) with input from friends like [Andy O'brien](https://github.com/javabudd) and [Harry Wallin](https://github.com/BillwoodMarbles).

We hope you enjoy it!
