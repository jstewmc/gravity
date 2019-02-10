<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Data;

use Jstewmc\Gravity\Id\Data\Service as Id;
use Jstewmc\Gravity\Ns\Data\Parsed as Ns;
use PHPUnit\Framework\TestCase;

class FxTest extends TestCase
{
    public function testGetDefinition(): void
    {
        $definition = function () {
            return;
        };

        $service = new Fx(
            $this->createMock(Id::class),
            $definition,
            $this->createMock(Ns::class)
        );

        $this->assertSame($definition, $service->getDefinition());
    }

    public function testGetId(): void
    {
        $id = $this->createMock(Id::class);

        $service = new Fx(
            $id,
            function () {
                return;
            },
            $this->createMock(Ns::class)
        );

        $this->assertSame($id, $service->getId());
    }

    public function testGetNamespace(): void
    {
        $namespace = $this->createMock(Ns::class);

        $service = new Fx(
            $this->createMock(Id::class),
            function () {
                return;
            },
            $namespace
        );

        $this->assertSame($namespace, $service->getNamespace());
    }
}
