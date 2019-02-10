<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Example\Service;

class Bar
{
    public function __invoke(): string
    {
        return 'bar';
    }
}
