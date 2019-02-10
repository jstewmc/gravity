<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Exception;

use Jstewmc\Gravity\Id\Data\Id;
use PHPUnit\Framework\TestCase;

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
