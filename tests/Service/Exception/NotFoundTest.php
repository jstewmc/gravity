<?php
/**
 * The file for the "service not found" exception
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Exception;

use Jstewmc\Gravity\Id\Data\Service as Id;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the "service not found" exception
 *
 * @since  0.1.0
 */
class NotFoundTest extends TestCase
{
    public function testId(): void
    {
        $id = $this->createMock(Id::class);

        $exception = new NotFound($id);

        $this->assertSame($id, $exception->getId());

        return;
    }
}
