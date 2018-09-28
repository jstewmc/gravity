# Gravity

Gravity is a framework-agnostic, community-friendly service and configuration manager.

Gravity makes it easy to use other people's settings and services in your application. As a _package author_, you'll use Gravity to _set_ settings and services. As a _package consumer_ you'll use Gravity to _get_ settings and services.

Suppose:

1. You've installed a library using Composer, and
2. You'd like to use a service defined in the library.

Gravity:

1. Finds the service,
2. Reads its definition,
3. Instantiates it,
4. Returns it to you, and
5. Saves it for the next request.

Gravity makes it easy to create and share services and settings. It just pulls everything together.

## Usage

Here's a simple example.

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

You'll define the service in a Gravity file (`$g`, the standard abbreviation for [gravity](https://en.wikipedia.org/wiki/Standard_gravity), is a magic variable in Gravity files, and PHP's `::class` constant is a convenient way to identify services):

```php
# /path/to/project/.gravity/services.php
namespace Foo\Bar;

$g->set(Baz::class, function (): object {
    return new Baz();
});
```

And, you'll add your (awesome) `Foo\Bar` package to Packagist for others to use.

### Package consumers

As a _package consumer_, you'll add the `Foo\Bar` package to your `composer.json` file.

And, you'll use the `Baz` service in your application:

```php
# path/to/project/file.php
namespace Foo\Bar;

use Jstewmc\Gravity\Manager;
use Foo\Bar\Baz;

$g = new Manager();

$g->get(Baz::class)();
```

The code above would produce the following output:

```
baz
```

That's it!

## Documentation

Of course, there is much more that Gravity can do (including configuration)!

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
