<?php
/**
 * The file for the parse-service service tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Service;

use Jstewmc\Gravity\FactoryTest;
use Jstewmc\Gravity\Id\Data\Service as Id;
use Jstewmc\Gravity\Service\Data\Factory;
use Jstewmc\Gravity\Service\Data\Fx;
use Jstewmc\Gravity\Service\Data\Instance;
use Jstewmc\Gravity\Service\Data\Newable;
use Jstewmc\Gravity\Service\Exception\BadDefinition;
use PHPUnit\Framework\TestCase;
use StdClass;

/**
 * Tests for the parse-service service
 *
 * @since  0.1.0
 */
class ParseTest extends TestCase
{
    public function testInvokeThrowsExceptionIfBadDefinition(): void
    {
        $this->expectException(BadDefinition::class);

        $id = $this->createMock(Id::class);

        (new Parse())($id, 1);

        return;
    }

    public function testInvokeReturnsServiceIfFactory(): void
    {
        $id = $this->createMock(Id::class);
        $definition = FactoryTest::class;

        $expected = new Factory($id, $definition);
        $actual   = (new Parse())($id, $definition);

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeReturnsServiceIfFx(): void
    {
        $id = $this->createMock(Id::class);
        $definition = function () {
            return;
        };

        $expected = new Fx($id, $definition);
        $actual   = (new Parse())($id, $definition);

        $this->assertEquals($expected, $actual);

        return;
    }

    /**
     * We had an issue where an object that implemented the __invoke() method
     * was considered a function, which it's not.
     */
    public function testInvokeReturnsServiceIfObjectImplementsInvoke(): void
    {
        $id = $this->createMock(Id::class);
        $definition = new Class {
            public function __invoke()
            {
                return;
            }
        };

        $expected = new Instance($id, $definition);
        $actual   = (new Parse())($id, $definition);

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeReturnsServiceIfInstance(): void
    {
        $id = $this->createMock(Id::class);
        $definition = new StdClass();

        $expected = new Instance($id, $definition);
        $actual   = (new Parse())($id, $definition);

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeReturnsServiceIfNewable(): void
    {
        $id = $this->createMock(Id::class);
        $id->method('__toString')->willReturn('StdClass');

        $expected = new Newable($id);
        $actual   = (new Parse())($id);

        $this->assertEquals($expected, $actual);

        return;
    }
}
