## Identifiers

An identifier (aka, "id") uniquely identifies a service or setting within Gravity.

An identifier must be three or more segments of at least one character separated by a separator, which differs by type. Service identifiers use PHP's namespace separator (e.g., `'foo\bar\baz'`), and setting identifiers use a period (e.g., `'foo.bar.baz'`).

Using PHP's `::class` constant to identify services is convenient. First, using classnames insures uniqueness because no two classes can have the same name. Second, your users can can use PHP's `namespace` and `use` statements to quickly request a service.

Setting identifiers, on the other hand, are admittedly a bit cumbersome. There is no convenient `::class` constant for them. But, we are working on some ideas to make them easier to use (and we welcome your ideas too).

Identifiers are case-insensitive. No matter what case you use to define them, users can use any case to request them. The following setting identifiers are all equivalent: `'FOO.BAR.BAZ'`, `'foo.bar.baz'`, and `'fOo.Bar.BAZ'`.
