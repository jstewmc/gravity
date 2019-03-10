<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Service;

use Error;
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
    }

    public function testInvokeIfFxCallsPrivateMethods(): void
    {
        $namespace = $this->createMock(Ns::class);

        $function  = function () {
            $this->getId('foo.bar.baz');
        };

        $service = new Fx($this->id, $function, $namespace);

        // hmm, I (Jack) couldn't figure out to get PHPUnit to expect an error;
        //     the expectException(Error::class) didn't work
        try {
            (new Instantiate())($service, $this->g);
            $this->assertTrue(false, "Closure accessed manager's private methods");
        } catch (Error $e) {
            $this->assertTrue(true);
        }
    }

    public function testInvokeIfInstance()
    {
        $service = new Instance($this->id, new StdClass());

        $sut = new Instantiate();

        $this->assertInstanceOf(StdClass::class, $sut($service, $this->g));
    }

    public function testInvokeIfNewable()
    {
        $this->id->method('getSegments')->willReturn(['StdClass']);

        $service = new Newable($this->id);

        $sut = new Instantiate();

        $this->assertInstanceOf(StdClass::class, $sut($service, $this->g));
    }
}
