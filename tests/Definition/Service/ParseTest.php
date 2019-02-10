<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Definition\Service;

use Jstewmc\Gravity\Definition\Data\{Parsed, Read};
use Jstewmc\Gravity\Path\Data\Path;
use Jstewmc\Gravity\Path\Service\Parse as ParsePath;
use PHPUnit\Framework\TestCase;

class ParseTest extends TestCase
{
    public function testInvoke(): void
    {
        $path = $this->createMock(Path::class);

        $parsePath = $this->createMock(ParsePath::class);
        $parsePath->method('__invoke')->willReturn($path);

        $sut = new Parse($parsePath);

        $definition = new Read('foo');

        $expected = new Parsed($path);
        $actual   = $sut($definition);

        $this->assertEquals($expected, $actual);

        return;
    }
}
