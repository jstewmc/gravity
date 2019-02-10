<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Root\Exception;

use PHPUnit\Framework\TestCase;

class NotReadableTest extends TestCase
{
    public function testGetPathname(): void
    {
        $pathname = '/path/to/foo';

        $exception = new NotReadable($pathname);

        $this->assertEquals($pathname, $exception->getPathname());
    }
}
