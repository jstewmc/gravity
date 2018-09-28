<?php
/**
 * The file for the "not directory" filesystem exception
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Filesystem\Exception;

use PHPUnit\Framework\TestCase;

/**
 * Tests for the "not directory" filesystem exception
 *
 * @since  0.1.0
 */
class NotDirectoryTest extends TestCase
{
    public function testGetPathname(): void
    {
        $pathname = 'foo';

        $exception = new NotDirectory($pathname);

        $this->assertEquals($pathname, $exception->getPathname());

        return;
    }
}
