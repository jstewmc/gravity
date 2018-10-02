<?php
/**
 * The file for factory service tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Data;

use Jstewmc\Gravity\Id\Data\Service as Id;
use PHPUnit\Framework\TestCase;

/**
 * Tests for a factory service
 *
 * @since  0.1.0
 */
class FactoryTest extends TestCase
{
    public function testGetId(): void
    {
        $id = $this->createMock(Id::class);

        $service = new Factory($id, 'foo');

        $this->assertSame($id, $service->getId());

        return;
    }

    public function testGetDefinition(): void
    {
        $id = $this->createMock(Id::class);

        $service = new Factory($id, 'foo');

        $this->assertSame('foo', $service->getDefinition());

        return;
    }
}
