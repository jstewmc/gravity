<?php

namespace Jstewmc\Gravity\Example\Service;

use Jstewmc\Gravity\Manager;

require_once realpath(__DIR__ . '/../vendor/autoload.php');

$g = new Manager();

$expected = 2;
$actual   = $g->get('jstewmc.gravity.example.setting.quux');

assert($expected == $actual);

$expected = ['corge', 'grault'];
$actual   = $g->get('jstewmc.gravity.example.setting.quuz');

assert($expected == $actual);

$expected = 1;
$actual   = $g->get('jstewmc.gravity.example.setting.corge.garply.waldo.fred');

assert($expected == $actual);
