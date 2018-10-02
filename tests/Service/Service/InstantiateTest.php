<?php
/**
 * The file for the instantiate-service service tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Service;

use Jstewmc\Gravity\FactoryTest;
use Jstewmc\Gravity\Id\Data\Service as Id;
use Jstewmc\Gravity\Manager;
use Jstewmc\Gravity\Service\Data\Factory;
use Jstewmc\Gravity\Service\Data\Fx;
use Jstewmc\Gravity\Service\Data\Instance;
use Jstewmc\Gravity\Service\Data\Newable;
use PHPUnit\Framework\TestCase;
use StdClass;

/**
 * Tests for the instantiate-service service
 *
 * @since  0.1.0
 */
class InstantiateTest extends TestCase
{
    public function testInvokeReturnsObjectIfFactory()
    {
        $id = $this->createMock(Id::class);
        $definition = FactoryTest::class;

        $service = new Factory($id, $definition);

        // set up the system under test (aka, "sut")
        $manager = $this->createMock(Manager::class);
        $manager->method('get')->willReturn(new FactoryTest());

        $sut = new Instantiate($manager);

        $this->assertInstanceOf(StdClass::class, $sut($service));

        return;
    }

    public function testInvokeReturnsObjectIfFx(): void
    {
        // set up the anonymous-function-defined service to instantiate
        $id = $this->createMock(Id::class);
        $definition = function () {
            return new StdClass();
        };

        $service = new Fx($id, $definition);

        // set up the system under test (aka, "sut")
        $manager = $this->createMock(Manager::class);

        $sut = new Instantiate($manager);

        $this->assertInstanceOf(StdClass::class, $sut($service));

        return;
    }

    public function testInvokeReturnsObjectIfInstance()
    {
        // set up the instance-defined service to instantiate
        $id = $this->createMock(Id::class);
        $definition = new StdClass();

        $service = new Instance($id, $definition);

        // set up the system under test (aka, "sut")
        $manager = $this->createMock(Manager::class);

        $sut = new Instantiate($manager);

        $this->assertInstanceOf(StdClass::class, $sut($service));

        return;
    }

    public function testInvokeReturnsObjectIfNewable()
    {
        // set up the newable-defined service to instantiate
        $id = $this->createMock(Id::class);
        $id->method('__toString')->willReturn('StdClass');

        $service = new Newable($id);

        // set up the system under test (aka, "sut")
        $manager = $this->createMock(Manager::class);

        $sut = new Instantiate($manager);

        $this->assertInstanceOf(StdClass::class, $sut($service));

        return;
    }
}
