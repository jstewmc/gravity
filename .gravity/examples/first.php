<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */
 
namespace Jstewmc\Gravity\Example\Service;

$g->set('jstewmc.gravity.example.foo', true);

$g->set(Foo::class, function (): Foo {
    return new Foo();
});
