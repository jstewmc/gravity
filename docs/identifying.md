[Home](index.md) | [**Identifying**](identifying.md) | [Setting](setting.md) | [Getting](getting.md) | [Aliasing](aliasing.md) | [Deprecating](deprecating.md) | [Logging](logging.md) | [Caching](caching.md)

# Identifying services and settings

Gravity uses a string identifier (aka, an "id") to uniquely identify a service or setting.

An identifier must be three or more segments separated by a separator. The separator differs by type: _services_ use PHP's namespace separator (e.g., `'foo\bar\baz'`), and _setting_ use a period (e.g., `'foo.bar.baz'`):

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

## Service identifiers

A service identifier is usually a fully-qualified classname (e.f., `'Foo\Bar\Baz'`).

Using actual classnames is convenient:

- it ensures uniqueness, and,
- it permits PHP's `namespace`, `use`, and `::class` features as shortcuts.

To learn more about namespaces, see PHP's [namespace resolution rules](http://php.net/manual/en/language.namespaces.rules.php).


## Setting identifiers

Setting identifiers, on the other hand, are literal strings separated by a dot (e.g., `'foo.bar.baz'`). Unfortunately, there are no shortcuts like PHP's `::class` constant. However, there is hope!

## Namespace

Identifiers can get long, especially for larger packages, and as literal strings, setting identifiers are a pain. To make it easier to deal with identifiers, Gravity provides the `namespace` and `use` methods:

```php
// define a namespace
$g->namespace('foo.bar.baz');

// import a namespace (alias is optional)
$g->use("Foo\Bar\Qux");
$g->use("Foo\Bar\Quux", "Corge");
```

Here are a few psuedo-examples with the plumbing of a working example omitted to focus on the resolution rules.

### Default

By default, a file without a `namespace` or `use` statements will default to the global namespace, and identifiers will resolve as-is:

```
'Foo\Bar\Baz'  // resolves to "Foo\Bar\Baz"
'foo.bar.baz'  // resolves to "foo.bar.baz"
```

### With namespace

When a namespace is defined, it is prepended to every identifier in the file.

```
$g->namespace('foo.bar.baz');

'qux.quux.corge'       // resolves to "foo.bar.baz.qux.quux.corge"
'grault.garply.waldo'  // resolves to "foo.bar.baz.grault.garply.waldo"
```

Unless, you use a leading separator to escape the namespace:

```
$g->namespace('foo.bar.baz');

'qux.quux.corge'   // resolves to "foo.bar.baz.qux.quux.corge"
'.qux.quux.corge'  // resolves to "qux.quux.corge"
```

Unfortunately, a namespace is not a great option if you're going to mix settings and services in the same file, because it is prepended to _every_ identifier, regardless of type:

```
$g->namespace('foo.bar.baz');

'qux.quux.corge'  // resolves to "foo.bar.baz.qux.quux.corge" (good!)
'Qux\Quux\Corge'  // throws exception because types don't match
```

That is, unless you use imported namespaces.

### With imports

Imported namespaces are added to a file under an alias. If an alias is not explictly defined, the last segment in the namespace will be used:

```
$g->use('Foo\Bar\Baz');         // uses the implicit alias "baz"
$g->use('Foo\Bar\Baz', 'Baz');  // uses the explicit alias "baz"
$g->use('Foo\Bar\Baz', 'Qux');  // uses the explicit alias "qux"
```

You can use as many imports namespaces as you like in a file.

Imported namespaces are resolved before the file's namespace. So, if you mix services and settings in the same file, you can use a namespace for one type and imported namespaces for another:

```
$g->namespace('foo.bar.baz');

$g->use('Foo\Bar\Baz');

'qux.quux.corge'      // resolves to "foo.bar.baz.qux.quux.corge"
'Baz\Qux\Quux\Corge'  // resolves to "Foo\Bar\Baz\Qux\Quux\Corge"
```

Just be careful of alias collisions. The last alias will always win:

```
$g->use('foo.bar.baz');
$g->use('Foo\Bar\Baz');

'baz.qux.quux.corge'  // throws an exception because the last "baz" alis won!
```

### Rules

More formally, here are the resolution rules:

1. Identifiers are case-insensitive.
2. Fully qualified names always resolve to the name without the leading separator (e.g., `.foo.bar.baz` resolves to `foo.bar.baz`).
3. Relative names are resolved within the current namespace (e.g., in the `foo.bar.baz` namespace `qux.quux.corge` will resolve to `foo.bar.baz.qux.quux.corge`).
4. Qualified names are resolved according to the current import table (e.g., if `foo.bar.baz` was imported under the alias `baz`, `baz.qux.quux.corge` will resolve to `foo.bar.baz.qux.quux.corge`).


## That's it!

Next up, [setting services and setting](setting.md)!
