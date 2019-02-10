<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Service;

use Jstewmc\Gravity\FactoryTest;
use Jstewmc\Gravity\Id\Data\Service as Id;
use Jstewmc\Gravity\Manager\Data\Manager;
use Jstewmc\Gravity\Ns\Data\Parsed as Ns;
use Jstewmc\Gravity\Service\Data\{Factory, Fx, Instance, Newable};
use PHPUnit\Framework\TestCase;
use StdClass;

/**
 * @group  service
 */
class InstantiateTest extends TestCase
{
    public function testInvokeIfFactory()
    {
        $service = new Factory(
            $this->createMock(Id::class),
            FactoryTest::class
        );

        $manager = $this->createMock(Manager::class);
        $manager->method('get')->willReturn(new FactoryTest());

        $sut = new Instantiate();

        $this->assertInstanceOf(StdClass::class, $sut($service, $manager));

        return;
    }

    public function testInvokeIfFx(): void
    {
        $service = new Fx(
            $this->createMock(Id::class),
            function () {
                return new StdClass();
            },
            $this->createMock(Ns::class)
        );

        $manager = $this->createMock(Manager::class);

        $sut = new Instantiate();

        $this->assertInstanceOf(StdClass::class, $sut($service, $manager));

        return;
    }

    public function testInvokeIfInstance()
    {
        $service = new Instance(
            $this->createMock(Id::class),
            new StdClass()
        );

        $manager = $this->createMock(Manager::class);

        $sut = new Instantiate();

        $this->assertInstanceOf(StdClass::class, $sut($service, $manager));

        return;
    }

    public function testInvokeIfNewable()
    {
        $id = $this->createMock(Id::class);
        $id->method('__toString')->willReturn('StdClass');

        $service = new Newable($id);

        $manager = $this->createMock(Manager::class);

        $sut = new Instantiate();

        $this->assertInstanceOf(StdClass::class, $sut($service, $manager));

        return;
    }
}
