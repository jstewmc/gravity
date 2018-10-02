<?php
/**
 * The file for newable service tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Data;

use Jstewmc\Gravity\Id\Data\Service as Id;
use PHPUnit\Framework\TestCase;

/**
 * Tests for a newable service
 *
 * @since  0.1.0
 */
class NewableTest extends TestCase
{
    public function testGetId(): void
    {
        $id = $this->createMock(Id::class);

        $service = new Newable($id);

        $this->assertSame($id, $service->getId());

        return;
    }

    public function testGetDefinition(): void
    {
        $id = $this->createMock(Id::class);
        $definition = 'StdClass';

        $service = new Newable($id);

        $this->assertNull($service->getDefinition());

        return;
    }
}
