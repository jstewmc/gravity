# Getting services and settings

As a _package consumer_ you'll use Gravity to _get_ services and settings that other developers have defined.

## Gravity manager

To get a setting or service from Gravity you need an instance of the manager (often abbreviated `$g`, the abbreviation for [gravity](https://en.wikipedia.org/wiki/Gravity_of_Earth)) and the setting or service identifier. That's it!

When the Gravity manager is instantiated, it loads settings and services from the project filesystem. Sometimes, this may involve reading hundreds of files and thousands of settings and services. This is not an fast operation!

For best performance, use a single instance of the Gravity manager, and make sure it survives as long as possible over the lifetime of your application.

As a new library, Gravity doesn't have integrations for the major frameworks. Until it does, it's up to you to figure out how to keep Gravity around as long as possible. If you have a good solution, feel free to open a pull request or [let us know](mailto:clayjs0@gmail.com)!

## Requests

Once you have an instance of the manager, you're set! Just call the manager's `get()` method with the identifier of the setting or service you'd like.

```php
# /path/to/project/file.php
namespace Foo\Bar;

use Jstewmc\Gravity\Manager;

$g = new Manager();

$g->get('foo.bar.baz');
$g->get(Baz::class);
```
