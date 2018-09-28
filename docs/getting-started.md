# Getting started

Gravity is a framework-agnostic service and configuration manager. It allows _package authors_ to [set services and settings](setting.md), and it allows _package consumers_ to [get services and settings](getting.md).

Suppose:

1. You'd like to use a service defined in a library, and
2. You've installed the library using Composer.

Gravity:

1. Finds the service,
2. Reads its definition,
3. Instantiates it,
4. Returns it to you, and
5. Saves it for the next request.

Gravity makes it easy to create and share services and settings. It just pulls everything together.

To get started:

1. [Install Gravity](https://github.com/jstewmc/gravity#installation);
2. [Learn how identifiers work](identifiers.md);
3. [Learn how to set services and settings](setting.md); and,
4. [Learn how to get services and settings](getting.md).
