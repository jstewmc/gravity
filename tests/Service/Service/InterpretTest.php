<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Service;

use Jstewmc\Gravity\FactoryTest;
use Jstewmc\Gravity\Definition\Data\Resolved as Definition;
use Jstewmc\Gravity\Id\Data\Service as Id;
use Jstewmc\Gravity\Ns\Data\Parsed as Ns;
use Jstewmc\Gravity\Service\Data\{Factory, Fx, Instance, Newable};
use Jstewmc\Gravity\Service\Exception\InvalidDefinition;
use PHPUnit\Framework\TestCase;
use StdClass;

class ParseTest extends TestCase
{
    public function testInvokeThrowsExceptionIfInvalidDefinition(): void
    {
        $this->expectException(InvalidDefinition::class);

        $definition = $this->mockDefinition(1);

        (new Interpret())($definition, $this->mockNamespace());
    }

    public function testInvokeIfFactory(): void
    {
        $definition = $this->mockDefinition(FactoryTest::class);

        $expected = new Factory($definition->getKey(), $definition->getValue());
        $actual   = (new Interpret())($definition, $this->mockNamespace());

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeIfFx(): void
    {
        $namespace = $this->mockNamespace();

        $definition = $this->mockDefinition(function () {
            return;
        });

        $expected = new Fx(
            $definition->getKey(),
            $definition->getValue(),
            $namespace
        );

        $actual   = (new Interpret())($definition, $namespace);

        $this->assertEquals($expected, $actual);

        return;
    }

    /**
     * Added when a class that implemented the __invoke() method was considered
     * an fx service, when it should be considered a newable.
     */
    public function testInvokeIfInstanceImplementsInvoke(): void
    {
        $definition = $this->mockDefinition(
            new Class {
                public function __invoke()
                {
                    return;
                }
            }
        );

        $expected = new Instance($definition->getKey(), $definition->getValue());
        $actual   = (new Interpret())($definition, $this->mockNamespace());

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeIfInstance(): void
    {
        $definition = $this->mockDefinition(new StdClass());

        $expected = new Instance($definition->getKey(), $definition->getValue());
        $actual   = (new Interpret())($definition, $this->mockNamespace());

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeIfNewable(): void
    {
        $id = $this->createMock(Id::class);
        $id->method('__toString')->willReturn('StdClass');

        $definition = $this->createMock(Definition::class);
        $definition->method('getKey')->willReturn($id);
        $definition->method('getValue')->willReturn(null);

        $expected = new Newable($id);
        $actual   = (new Interpret())($definition, $this->mockNamespace());

        $this->assertEquals($expected, $actual);

        return;
    }

    private function mockNamespace()
    {
        return $this->createMock(Ns::class);
    }

    private function mockDefinition($value)
    {
        // the majority of tests don't care about the id
        $id = $this->createMock(Id::class);

        $definition = $this->createMock(Definition::class);
        $definition->method('getKey')->willReturn($id);
        $definition->method('getValue')->willReturn($value);

        return $definition;
    }
}
