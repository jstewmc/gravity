<?php

namespace Jstewmc\Gravity\Example;

use Jstewmc\Gravity\Gravity;

require_once realpath(__DIR__ . '/../vendor/autoload.php');

$g = (new Gravity())->pull();

// using the settings from ../.gravity/examples/setting.php:31
$expected = true;
$actual   = $g->get('jstewmc.gravity.example.setting.foo');

assert($expected == $actual);

// using the settings from ../.gravity/examples/setting.php:12
$instance = $g->get(Service\Qux::class);

assert($instance instanceof Service\Qux);

$a = $g->get(Service\Qux::class);
$b = $g->get(Service\Qux::class);

// remember, PHP's === operator compares the object's references in memory
assert($a === $b);
