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

class InstantiateTest extends TestCase
{
    private $g;

    private $id;

    public function setUp(): void
    {
        $this->id = $this->createMock(Id::class);
        $this->g  = $this->createMock(Manager::class);
    }

    public function testInvokeIfFactory()
    {
        $service = new Factory($this->id, FactoryTest::class);

        $this->g->method('get')->willReturn(new FactoryTest());

        $sut = new Instantiate();

        $this->assertInstanceOf(StdClass::class, $sut($service, $this->g));

        return;
    }

    public function testInvokeIfFx(): void
    {
        $namespace = $this->createMock(Ns::class);
        $function  = function () {
            return new StdClass();
        };

        $service = new Fx($this->id, $function, $namespace);

        $sut = new Instantiate();

        $this->assertInstanceOf(StdClass::class, $sut($service, $this->g));

        return;
    }

    public function testInvokeIfInstance()
    {
        $service = new Instance($this->id, new StdClass());

        $sut = new Instantiate();

        $this->assertInstanceOf(StdClass::class, $sut($service, $this->g));

        return;
    }

    public function testInvokeIfNewable()
    {
        $this->id->method('getSegments')->willReturn(['StdClass']);

        $service = new Newable($this->id);

        $sut = new Instantiate();

        $this->assertInstanceOf(StdClass::class, $sut($service, $this->g));

        return;
    }
}
