<?php

namespace Jstewmc\Gravity\Example\Service;

use Jstewmc\Gravity\Gravity;

require_once realpath(__DIR__ . '/../vendor/autoload.php');

$g = (new Gravity())->pull();

// Gravity returns an instance of Foo
assert($g->get(Foo::class) instanceof Foo);

// Gravity returns true
$expected = true;
$actual   = $g->get('jstewmc.gravity.example.foo');

assert($expected == $actual);
