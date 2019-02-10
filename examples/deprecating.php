<?php

namespace Jstewmc\Gravity\Example;

use Jstewmc\Gravity\Gravity;

require_once realpath(__DIR__ . '/../vendor/autoload.php');

$g = (new Gravity())->pull();

// without suggested replacement
$g->get('jstewmc.gravity.example.deprecating.foo');
$g->get(Deprecating\Foo::class);

// with suggested replacement
$g->get('jstewmc.gravity.example.deprecating.bar');
$g->get(Deprecating\Bar::class);
