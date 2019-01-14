<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Import\Service;

use Jstewmc\Gravity\Import\Data\{Parsed, Read};
use Jstewmc\Gravity\Path\Data\Path;
use Jstewmc\Gravity\Path\Service\Parse as ParsePath;
use PHPUnit\Framework\TestCase;

/**
 * @group  import
 */
class ParseTest extends TestCase
{
    public function testInvokeReturnsImportIfNameDoesExist(): void
    {
        $name = 'baz';

        $import = new Read('foo.bar.baz', $name);

        $path = $this->createMock(Path::class);

        $parsePath = $this->createMock(ParsePath::class);
        $parsePath->method('__invoke')->willReturn($path);

        $sut = new Parse($parsePath);

        $expected = new Parsed($path, $name);
        $actual   = $sut($import);

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeReturnsImportIfNameDoesNotExist(): void
    {
        $import = new Read('foo.bar.baz');

        $path = $this->createMock(Path::class);
        $path->method('getLastSegment')->willReturn('baz');

        $parsePath = $this->createMock(ParsePath::class);
        $parsePath->method('__invoke')->willReturn($path);

        $sut = new Parse($parsePath);

        $expected = new Parsed($path, 'baz');
        $actual   = $sut($import);

        $this->assertEquals($expected, $actual);

        return;
    }
}
