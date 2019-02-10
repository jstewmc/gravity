<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Script\Service;

use Jstewmc\Gravity\Script\Data\{Closed, Opened};
use PHPUnit\Framework\TestCase;

class CloseTest extends TestCase
{
    public function testInvoke(): void
    {
        $expected = new Closed();
        $actual   = (new Close())(new Opened());

        $this->assertEquals($expected, $actual);
    }
}
