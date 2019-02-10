<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Example\Service;

class Qux
{
    public function __invoke(): string
    {
        return 'qux';
    }
}
