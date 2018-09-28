<?php
/**
 * The file for the "bad service definition" exception
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Exception;

use Jstewmc\Gravity\Id\Data\Service as Id;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the "bad service definition" exception
 *
 * @since  0.1.0
 */
class BadDefinitionTest extends TestCase
{
    public function testGetDefinition(): void
    {
        $id = $this->createMock(Id::class);
        $definition = 1;

        $exception = new BadDefinition($id, $definition);

        $this->assertSame($definition, $exception->getDefinition());

        return;
    }

    public function testId(): void
    {
        $id = $this->createMock(Id::class);

        $exception = new BadDefinition($id, 1);

        $this->assertSame($id, $exception->getId());

        return;
    }
}
