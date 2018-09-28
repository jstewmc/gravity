<?php
/**
 * The file for the "deprecation not found" exception tests
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
class NotFoundTest extends TestCase
{
    public function testGetId(): void
    {
        $id = $this->createMock(Id::class);

        $exception = new NotFound($id);

        $this->assertSame($id, $exception->getId());

        return;
    }
}
