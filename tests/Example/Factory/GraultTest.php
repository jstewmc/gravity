<?php
/**
 * The file for the "grault" example test
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Example;

use Jstewmc\Gravity\Manager;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the "grault" example factory
 *
 * @since  0.1.0
 */
class GraultTest extends TestCase
{
    public function testInvoke(): void
    {
        $manager = $this->createMock(Manager::class);

        $expected = Service\Grault::class;
        $actual   = (new Factory\Grault())($manager);

        $this->assertInstanceOf($expected, $actual);

        return;
    }
}
