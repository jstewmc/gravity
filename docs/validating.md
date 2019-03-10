[Home](index.md) | [Identifying](identifying.md) | [Setting](setting.md) | [Getting](getting.md) | [Aliasing](aliasing.md) | [Deprecating](deprecating.md) | [Logging](logging.md) | [Caching](caching.md)

# Validating a project

Gravity allows developers to define required services and settings for their packages with an identifier and a description:

```php
$g->require('Foo\Bar\Baz', 'Lorem ipsum inum');
$g->require('foo.bar.baz', 'Dolor amet');
```

To check a project's requirements are met (and that all services can be instantiated successfully), Gravity provides a command-line tool, `gravity validate`:

```bash
/path/to/project $ gravity validate
```

If a project's requirements are met and all services can be instantiated without error, `validate` will print a success message:

```bash
/path/to/project $ gravity validate
Project is valid!
```

If not, `validate` will print error messages as a bulleted list:

```bash
/path/to/project $ gravity validate
Project is invalid! Found 1 errors:

    * jstewmc\gravity\example\service\quux: Instatiating service, 'jstewmc\gravity\example\service\quux', failed with Error: Class 'Jstewmc\Gravity\Example\Service\Asdf' not found
```
