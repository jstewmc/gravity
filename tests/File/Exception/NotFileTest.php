<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\File\Exception;

use PHPUnit\Framework\TestCase;

class NotFileTest extends TestCase
{
    public function testGetPathname(): void
    {
        $pathname = '/path/to/foo';

        $this->assertEquals($pathname, (new NotFile($pathname))->getPathname());
    }
}
