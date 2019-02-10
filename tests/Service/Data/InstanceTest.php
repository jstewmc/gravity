<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Data;

use Jstewmc\Gravity\Id\Data\Service as Id;
use PHPUnit\Framework\TestCase;
use StdClass;

class InstanceTest extends TestCase
{
    public function testGetId(): void
    {
        $id = $this->createMock(Id::class);

        $service = new Instance($id, new StdClass());

        $this->assertSame($id, $service->getId());
    }

    public function testGetDefinition(): void
    {
        $id = $this->createMock(Id::class);

        $definition = new StdClass();

        $service = new Instance($id, $definition);

        $this->assertSame($definition, $service->getDefinition());
    }
}
