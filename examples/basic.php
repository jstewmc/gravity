<?php

namespace Jstewmc\Gravity\Example\Service;

use Jstewmc\Gravity\Manager;

require_once realpath(__DIR__ . '/../vendor/autoload.php');

$g = new Manager();

// Gravity returns an instance of Foo
assert($g->get(Foo::class) instanceof Foo);

// Gravity returns true
$expected = true;
$actual   = $g->get('jstewmc.gravity.example.foo');

assert($expected == $actual);
