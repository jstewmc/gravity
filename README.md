# Gravity

Gravity is like Composer for settings and services: other developers define settings and services in your dependency injection container using files in their packages. By pulling everything together, Gravity makes it easy to build and share small, configurable services.

[![Build Status](https://travis-ci.com/jstewmc/gravity.svg?branch=master)](https://travis-ci.com/jstewmc/gravity) [![codecov](https://codecov.io/gh/jstewmc/gravity/branch/master/graph/badge.svg)](https://codecov.io/gh/jstewmc/gravity)

## Usage

Gravity serves two audiences: _package authors_, the developers who create packages, and _package consumers_, the developers who use them.

As a package author, you'll define services and settings in your repository using a simple file-based DSL:

```php
# /path/to/project/.gravity/foo.php

$g->set('foo.bar.baz', true);            // defines a setting
$g->set('Foo\Bar\Baz', new StdClass());  // defines a service
```

As a package consumer, you'll install packages via Composer; call Gravity's `pull()` method; and, request your service or setting using the `get()` method:

```php
# /path/to/project/file.php

$g = (new \Jstewmc\Gravity\Gravity())->pull();  // returns Gravity's manager

$g->get('foo.bar.baz');  // returns true
$g->get('Foo\Bar\Baz');  // returns the StdClass instance
```

## Documentation

Gravity's [documentation](https://github.com/jstewmc/gravity/blob/master/docs/index.md) is available online or in the `docs` directory.

We strive to maintain great documentation. If you see a mistake or have a suggestion, feel free to fork and fix it!

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

## Examples

You can run most examples in the documentation by cloning the repository to your computer, navigating to it on your filesystem, and using the PHP command line.

```bash
# navigate to a directory on your computer
$ cd ~/projects

# clone the repository to your computer
~/projects $ git clone https://github.com/jstewmc/gravity.git

# navigate to the repository
~/projects $ cd gravity

# run the first example
~/projects/gravity $ php examples/first.php
```

Most examples use `assert()` statements, and will output nothing when successful, unless stated otherwise.

## Compliance

This library strives to adhere to the following standards:

1. [Keep a Changelog 1.0](http://keepachangelog.com/en/1.0.0/)
2. [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)
3. [PSR-11](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-11-container.md)
4. [PSR-16](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-16-simple-cache.md)
5. [Semantic Versioning 2.0](http://semver.org/spec/v2.0.0.html)
6. [SODO Design Pattern 0.1.0](https://github.com/jstewmc/sodo-design-pattern)

If you spot an error, please let us know!

## License

This library is licensed under the [MIT license](LICENSE).

## Credits

This library was originally developed by [Jack Clayton](mailto:clayjs0@gmail.com) with input from good friends like [Andy O'brien](https://github.com/javabudd) and [Harry Wallin](https://github.com/BillwoodMarbles).

We hope you enjoy it!
