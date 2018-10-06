[Home](index.md) | [**Identifying**](identifying.md) | [Setting](setting.md) | [Getting](getting.md) | [Aliasing](aliasing.md) | [Deprecating](deprecating.md)

# Identifying services and settings

Gravity uses a string identifier (aka, an "id") to uniquely identify a service or setting.

An identifier must be three or more segments separated by a separator. The separator differs by type: _service identifiers_ use PHP's namespace separator (e.g., `'foo\bar\baz'`), and _setting identifiers_ use a period (e.g., `'foo.bar.baz'`):

```
"foo.bar.baz"                 // valid setting identifier
"foo.bar.baz.qux.quux.corge"  // valid setting identifier

"foo\bar\baz"                 // valid service identifier
"foo\bar\baz\qux\quux\corge"  // valid service identifier

"foo.bar"                     // invalid identifier, because too short
"foo-bar"                     // invalid identifier, because invalid separator
```

Identifiers are case-insensitive, and leading-separators, trailing-separators, and empty segments are ignored:

```
"foo.bar.baz"      // parses to "foo.bar.baz"
"FOO.bAr.BAZ"      // parses to "foo.bar.baz"
".foo.bar.baz"     // parses to "foo.bar.baz"
"foo.bar.baz."     // parses to "foo.bar.baz"
"foo...bar...baz"  // parses to "foo.bar.baz"
```

## Service identifiers

A service identifier should be a fully-qualified classname. It's not a hard and fast requirement. The class doesn't have to exist. But, the benefits of classname identifiers are too great to ignore: using a classname ensures uniqueness, and you can use PHP's `namespace`, `use`, and `::class` features as shortcuts. To learn more, see PHP's [namespace resolution rules](http://php.net/manual/en/language.namespaces.rules.php).


## Setting identifiers

Setting identifiers, on the other hand, are literal strings. They are admittedly a bit cumbersome, because there is no convenient `::class` constant for them. But, we are working on some ideas to make them easier to use, and we welcome your ideas too.

Next up, [setting services and setting](setting.md)!
