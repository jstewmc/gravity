<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Setting\Exception;

use Jstewmc\Gravity\Id\Data\Setting as Id;
use PHPUnit\Framework\TestCase;

/**
 * @group  setting
 */
class NotFoundTest extends TestCase
{
    public function testGetId(): void
    {
        $id = $this->createMock(Id::class);

        $exception = new NotFound($id);

        $this->assertSame($id, $exception->getId());
    }
}
