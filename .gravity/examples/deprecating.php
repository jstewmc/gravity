<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */
 
namespace Jstewmc\Gravity\Example;

// define settings to deprecate (use an array in real life)
$g->set('jstewmc.gravity.example.deprecating.foo', 0);
$g->set('jstewmc.gravity.example.deprecating.bar', 1);
$g->set('jstewmc.gravity.example.deprecating.baz', 2);

// define services to deprecate (using a fake namespace)
$g->set(Deprecating\Foo::class, function () {
    return new Service\Foo();
});

$g->set(Deprecating\Bar::class, function () {
    return new Service\Bar();
});

$g->set(Deprecating\Baz::class, function () {
    return new Service\Baz();
});

// deprecate a setting without replacement
$g->deprecate('jstewmc.gravity.example.deprecating.foo');

// deprecate a setting with a replacement
$g->deprecate(
    'jstewmc.gravity.example.deprecating.bar',
    'jstewmc.gravity.example.deprecating.baz'
);

// deprecate foo without a replacement
$g->deprecate(Deprecating\Foo::class);

// deprecate bar with a replacement
$g->deprecate(Deprecating\Bar::class, Deprecating\Baz::class);
