<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Example;

// define a setting to alias
$g->set('jstewmc.gravity.example.aliasing.foo', true);

// define services to alias (using a fake namespace)
$g->set(Aliasing\Foo::class, function () {
    return new Service\Foo();
});

$g->set(Aliasing\Bar::class, function () {
    return new Service\Bar();
});

// alias the service
$g->alias(Aliasing\Foo::class, Aliasing\Bar::class);

// alias the ssetting
$g->alias(
    'jstewmc.gravity.example.aliasing.bar',
    'jstewmc.gravity.example.aliasing.foo'
);
