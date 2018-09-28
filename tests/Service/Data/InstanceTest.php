<?php
/**
 * The file for instance service tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Data;

use Jstewmc\Gravity\Id\Data\Service as Id;
use PHPUnit\Framework\TestCase;
use StdClass;

/**
 * Tests for an instance service
 *
 * @since  0.1.0
 */
class InstanceTest extends TestCase
{
    public function testGetId(): void
    {
        $id = $this->createMock(Id::class);

        $service = new Instance($id, new StdClass());

        $this->assertSame($id, $service->getId());

        return;
    }

    public function testGetDefinition(): void
    {
        $id = $this->createMock(Id::class);
        $definition = new StdClass();

        $service = new Instance($id, $definition);

        $this->assertSame($definition, $service->getDefinition());

        return;
    }
}
