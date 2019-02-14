<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Ns\Service;

use Jstewmc\Gravity\Ns\Data\{Closed, Opened};
use PHPUnit\Framework\TestCase;

class CloseTest extends TestCase
{
    public function testInvoke(): void
    {
        $opened = $this->createMock(Opened::class);
        $opened->method('hasName')->willReturn(true);
        $opened->method('getname')->willReturn('foo');
        $opened->method('hasImports')->willReturn(true);
        $opened->method('getImports')->willReturn([]);

        $expected = (new Closed())->setName('foo')->setImports([]);
        $actual   = (new Close())($opened);

        $this->assertEquals($expected, $actual);
    }
}
