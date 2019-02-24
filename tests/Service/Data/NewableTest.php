<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Data;

use Jstewmc\Gravity\Id\Data\Service as Id;
use PHPUnit\Framework\TestCase;

class NewableTest extends TestCase
{
    public function testGetId(): void
    {
        $id = $this->createMock(Id::class);

        $service = new Newable($id);

        $this->assertSame($id, $service->getId());
    }

    public function testGetClassname(): void
    {
        $id = $this->createMock(Id::class);
        $id->method('getSegments')->willReturn(['StdClass']);

        $service = new Newable($id);

        $this->assertEquals('\StdClass', $service->getClassname());
    }

    public function testGetDefinition(): void
    {
        $id = $this->createMock(Id::class);

        $service = new Newable($id);

        $this->assertNull($service->getDefinition());
    }
}
