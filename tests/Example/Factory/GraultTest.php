<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Example;

use Jstewmc\Gravity\Manager\Data\Manager;
use PHPUnit\Framework\TestCase;

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
