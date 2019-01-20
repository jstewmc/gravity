<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity;

use Jstewmc\Gravity\Factory;
use StdClass;

// Define a concrete factory for use in tests.
class FactoryTest implements Factory
{
    public function __invoke(Manager $g): StdClass
    {
        return new StdClass();
    }
}
