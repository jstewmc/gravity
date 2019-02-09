<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\File\Service;

use Jstewmc\Gravity\File\Data\{Opened, Closed, Parsed};
use PHPUnit\Framework\TestCase;

/**
 * @group  file
 */
class GetTest extends TestCase
{
    public function testInvoke(): void
    {
        $pathname = '/path/to/foo.php';

        $opened = $this->createMock(Opened::class);
        $open   = $this->createMock(Open::class);
        $open->method('__invoke')->willReturn($opened);

        $read = $this->createMock(Read::class);
        $read->method('__invoke')->willReturn($opened);

        $closed = $this->createMock(Closed::class);
        $close  = $this->createMock(Close::class);
        $close->method('__invoke')->willReturn($closed);

        $parsed = $this->createMock(Parsed::class);
        $parse  = $this->createMock(Parse::class);
        $parse->method('__invoke')->willReturn($parsed);

        $sut = new Get($open, $read, $close, $parse);

        $this->assertEquals($parsed, $sut($pathname));
    }
}
