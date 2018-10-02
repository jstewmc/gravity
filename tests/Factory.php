<?php
/**
 * The file for a concrete factory
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity;

use Jstewmc\Gravity\Factory;
use StdClass;

/**
 * A concrete factory for tests
 *
 * A factory-defined service uses the string name of a service in the service
 * manager. The class must implement the Factory interface. Rather than define
 * single-use concrete classes we'll create a single concrete implementation.
 *
 * @since  0.1.0
 */
class FactoryTest implements Factory
{
    public function __invoke(Manager $g): StdClass
    {
        return new StdClass();
    }
}
