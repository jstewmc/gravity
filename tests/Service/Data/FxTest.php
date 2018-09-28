<?php
/**
 * The file for anonymouse function service tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Data;

use Jstewmc\Gravity\Id\Data\Service as Id;
use PHPUnit\Framework\TestCase;

/**
 * Tests for an anonymous function service
 *
 * @since  0.1.0
 */
class FxTest extends TestCase
{
    public function testGetId(): void
    {
        $id = $this->createMock(Id::class);

        $service = new Fx($id, function () { return; });

        $this->assertSame($id, $service->getId());

        return;
    }

    public function testGetDefinition(): void
    {
        $id = $this->createMock(Id::class);
        $definition = function () { return; };

        $service = new Fx($id, $definition);

        $this->assertSame($definition, $service->getDefinition());

        return;
    }
}
