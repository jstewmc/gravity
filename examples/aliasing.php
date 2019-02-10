<?php

namespace Jstewmc\Gravity\Example;

use Jstewmc\Gravity\Gravity;

require_once realpath(__DIR__ . '/../vendor/autoload.php');

$g = (new Gravity())->pull();

$a = $g->get('jstewmc.gravity.example.aliasing.foo');
$b = $g->get('jstewmc.gravity.example.aliasing.bar');

assert($a == $b);

$c = $g->get(Aliasing\Foo::class);
$d = $g->get(Aliasing\Bar::class);

assert($c === $d);
