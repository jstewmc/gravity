<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Root\Exception;

use PHPUnit\Framework\TestCase;

/**
 * @group  root
 */
class NotDirectoryTest extends TestCase
{
    public function testGetPathname(): void
    {
        $pathname = '/path/to/foo';

        $exception = new NotDirectory($pathname);

        $this->assertEquals($pathname, $exception->getPathname());
    }
}
