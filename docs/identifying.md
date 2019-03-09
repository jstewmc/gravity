[Home](index.md) | [**Identifying**](identifying.md) | [Setting](setting.md) | [Getting](getting.md) | [Aliasing](aliasing.md) | [Deprecating](deprecating.md) | [Logging](logging.md) | [Caching](caching.md)

# Identifying services and settings

Gravity uses a string identifier (aka, an "id") to uniquely identify a service or setting.

An identifier must be three or more segments separated by a separator: PHP's namespace separator for _services_ (e.g., `'foo\bar\baz'`), and a period for _settings_ (e.g., `'foo.bar.baz'`).

```
"foo.bar.baz"                 // valid setting identifier
"foo.bar.baz.qux.quux.corge"  // valid setting identifier

"foo\bar\baz"                 // valid service identifier
"foo\bar\baz\qux\quux\corge"  // valid service identifier

"foo.bar"                     // invalid identifier, because too short
"foo-bar"                     // invalid identifier, because invalid separator
```

Identifiers are case-insensitive and empty segments are ignored:

```
"foo.bar.baz"      // parses to "foo.bar.baz"
"FOO.bAr.BAZ"      // parses to "foo.bar.baz"
".foo.bar.baz"     // parses to "foo.bar.baz"
"foo.bar.baz."     // parses to "foo.bar.baz"
"foo...bar...baz"  // parses to "foo.bar.baz"
```

## Why so opinionated?

Gravity is admittedly opinionated about identifiers but for good reason.

Using three or more segments reduces identifier collisions, much like PSR-4's autoloading conventions help reduce classname collisions. Since services and settings are defined in packages, following the standard `vendor`, `package`, `segment1`[, `segment2`, ...] convention seems sensible.

Using a standard separator reduces verbosity and improves interoperability. If Gravity couldn't detect the identifier's type from the identifier itself, we would need to provide separate setting and service versions of every DSL method (e.g., `setSetting()`, `getService()`, `aliasSetting()`, etc), which gets cumbersome. Plus, it would be difficult to merge settings across a project with arbitrary separators in every package.

## Service identifiers

A service identifier is usually a fully-qualified classname (e.f., `'Foo\Bar\Baz'`).

Using class (or interface) names is convenient:

- it ensures uniqueness, and,
- it permits PHP's `namespace`, `use`, and `::class` features as shortcuts.

To learn more about namespaces, see PHP's [namespace resolution rules](http://php.net/manual/en/language.namespaces.rules.php).


## Setting identifiers

Setting identifiers, on the other hand, are literal strings separated by a dot (e.g., `'foo.bar.baz'`). Unfortunately, there are no native shortcuts like PHP's `::class` constant. However, there is hope!

## Namespaces

To make it easier to deal with setting identifiers (and service identifiers too), Gravity provides the `namespace` and `use` methods. These methods provide context for the rest of a file's identifiers, much like PHP's native `namespace` and `use` statements:

```php
// define a namespace
$g->namespace('foo.bar.baz');

// import a namespace (alias is optional)
$g->use("Foo\Bar\Qux");
$g->use("Foo\Bar\Quux", "Corge");
```

### Default

By default, a file without a `namespace` or `use` statements will default to the global namespace, and identifiers will resolve as-is:

```php
$g->set('Foo\Bar\Baz');     // resolves to "Foo\Bar\Baz"
$g->set('foo.bar.baz', 1);  // resolves to "foo.bar.baz"
```

### With namespace

When a namespace is defined, it is prepended to every identifier in the file:

```php
$g->namespace('foo.bar.baz');

$g->set('qux.quux.corge', 1);       // resolves to "foo.bar.baz.qux.quux.corge"
$g->set('grault.garply.waldo', 2);  // resolves to "foo.bar.baz.grault.garply.waldo"
```

Unless, you use a leading separator to escape the namespace:

```php
$g->namespace('foo.bar.baz');

$g->set('qux.quux.corge', 1);   // resolves to "foo.bar.baz.qux.quux.corge"
$g->set('.qux.quux.corge', 2);  // resolves to "qux.quux.corge"
```

Unfortunately, if you're going to mix settings and services in the same file, a namespace can cause trouble because it is prepended to _every_ identifier, regardless of type:

```php
$g->namespace('foo.bar.baz');

$g->set('qux.quux.corge', 1);  // resolves to "foo.bar.baz.qux.quux.corge" (good!)
$g->set('Qux\Quux\Corge');     // throws an exception because the types don't match
```

That is, unless you use imported namespaces.

### With imports

Imported namespaces are added to a file under an alias. If an alias is not explicitly defined, the last segment in the namespace will be used:

```php
$g->use('Foo\Bar\Baz');         // uses the implicit alias "baz"
$g->use('Foo\Bar\Baz', 'Bar');  // uses the explicit alias "bar"
```

You can use as many imported namespaces as you'd like in a file.

Imported namespaces are resolved before the file's namespace. So, if you mix services and settings in the same file, you can use a namespace for one type and imported namespaces for another:

```php
$g->namespace('foo.bar.baz');

$g->use('Foo\Bar\Baz');

$g->set('qux.quux.corge');      // resolves to "foo.bar.baz.qux.quux.corge"
$g->set('Baz\Qux\Quux\Corge');  // resolves to "Foo\Bar\Baz\Qux\Quux\Corge"
```

Just be careful of alias collisions. The last alias will always win (remember, case doesn't matter):

```php
$g->use('foo.bar.baz');
$g->use('Foo\Bar\Baz');

$g->set('baz.qux.quux.corge', 1)  // throws an exception for type mismatch
```

### Rules

More formally, here are the resolution rules:

1. Identifiers are case-insensitive.
2. Fully qualified names always resolve to the name without the leading separator (e.g., `.foo.bar.baz` resolves to `foo.bar.baz`).
3. Relative names are resolved within the current namespace (e.g., in the `foo.bar.baz` namespace `qux.quux.corge` will resolve to `foo.bar.baz.qux.quux.corge`).
4. Qualified names are resolved according to the current import table (e.g., if `foo.bar.baz` was imported under the alias `baz`, `baz.qux.quux.corge` will resolve to `foo.bar.baz.qux.quux.corge`).


## That's it!

Next up, [setting services and setting](setting.md)!
