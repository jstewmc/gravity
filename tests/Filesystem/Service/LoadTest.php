<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Filesystem\Service;

use Jstewmc\Gravity\File;
use Jstewmc\Gravity\Filesystem\Data\{Loaded, Traversed};
use PHPUnit\Framework\TestCase;

/**
 * @group  filesystem
 */
class LoadTest extends TestCase
{
    public function testInvoke(): void
    {
        $traversed = new Traversed([]);

        $get = $this->createMock(File\Service\Get::class);

        $run = $this->createMock(File\Service\Run::class);

        $sut = new Load($get, $run);

        $expected = new Loaded([]);
        $actual   = $sut($traversed);

        $this->assertEquals($expected, $actual);
    }
}
