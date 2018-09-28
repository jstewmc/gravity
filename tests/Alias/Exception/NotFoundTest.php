<?php
/**
 * The file for the "alias not found" exception tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Alias\Exception;

use Jstewmc\Gravity\Id\Data\Id;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the "alias not found" exception
 *
 * @since  0.1.0
 */
class NotFoundTest extends TestCase
{
    public function testConstruct(): void
    {
        $id = $this->createMock(Id::class);

        $exception = new NotFound($id);

        $this->assertSame($id, $exception->getId());

        return;
    }
}
