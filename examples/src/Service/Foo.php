<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Example\Service;

class Foo
{
    public function __invoke(): string
    {
        return 'foo';
    }
}
