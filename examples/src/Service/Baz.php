<?php
/*
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Example\Service;

class Baz
{
    public function __invoke(): string
    {
        return 'baz';
    }
}
