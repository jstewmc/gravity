<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Data;

use Jstewmc\Gravity\Id\Data\Service as Id;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
    public function testGetId(): void
    {
        $id = $this->createMock(Id::class);

        $service = new Factory($id, 'foo');

        $this->assertSame($id, $service->getId());
    }

    public function testGetDefinition(): void
    {
        $id = $this->createMock(Id::class);

        $service = new Factory($id, 'foo');

        $this->assertSame('foo', $service->getDefinition());
    }
}
