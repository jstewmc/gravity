<?php
/**
 * The file for the "circular deprecation" exception tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Exception;

use Jstewmc\Gravity\Id\Data\Id;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the "circular deprecation" exception
 *
 * @since  0.1.0
 */
class CircularTest extends TestCase
{
    public function testGetId(): void
    {
        $id = $this->createMock(Id::class);

        $exception = new Circular($id);

        $this->assertSame($id, $exception->getId());

        return;
    }
}
