<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Exception;

use Jstewmc\Gravity\Id\Data\Service as Id;
use PHPUnit\Framework\TestCase;

/**
 * @group  service
 */
class NotFoundTest extends TestCase
{
    public function testId(): void
    {
        $id = $this->createMock(Id::class);

        $exception = new NotFound($id);

        $this->assertSame($id, $exception->getId());
    }
}
