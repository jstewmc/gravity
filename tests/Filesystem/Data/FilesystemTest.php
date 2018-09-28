<?php
/**
 * The file for the filesystem tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Filesystem\Data;

use PHPUnit\Framework\TestCase;
use SplFileInfo;

/**
 * Tests for the filesystem
 *
 * @since  0.1.0
 */
class FilesystemTest extends TestCase
{
    public function testGetFiles(): void
    {
        $files = [new SplFileInfo('foo')];

        $filesystem = new Filesystem($files);

        $this->assertEquals($files, $filesystem->getFiles());

        return;
    }
}
