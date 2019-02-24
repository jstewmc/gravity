<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Path\Service;

use Jstewmc\Gravity\Path\Data\Setting as Path;
use Jstewmc\Gravity\Path\Exception\{EmptyPath, InvalidSeparator};
use PHPUnit\Framework\TestCase;

class ParseTest extends TestCase
{
    public function testInvokeThrowsExceptionIfInvalidSeparator(): void
    {
        $this->expectException(InvalidSeparator::class);

        (new Parse())('foo-bar-baz');

        return;
    }

    public function testInvokeThrowsExceptionIfBadLengthBeforeParsing(): void
    {
        $this->expectException(EmptyPath::class);

        (new Parse())('');

        return;
    }

    public function testInvokeThrowsExceptionIfBadLengthAfterParsing(): void
    {
        $this->expectException(EmptyPath::class);

        (new Parse())('...');

        return;
    }

    public function testInvokeIfWhitespaceExists(): void
    {
        $segments = ['foo', 'bar', 'baz'];

        $path = implode(Path::getSeparator(), $segments);
        $path = "   $path   ";

        $expected = new Path($segments);
        $actual   = (new Parse())($path);

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeIfMixedCaseExists(): void
    {
        $segments = ['FOO', 'bar', 'BaZ'];

        $path = implode(Path::getSeparator(), $segments);

        $expected = new Path(['FOO', 'bar', 'BaZ']);
        $actual   = (new Parse())($path);

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeIfEmptySegmentsExist(): void
    {
        $segments = ['foo', null, 'bar', 'baz'];

        $path = implode(Path::getSeparator(), $segments);

        $expected = new Path(['foo', 'bar', 'baz']);
        $actual   = (new Parse())($path);

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeIfLeadingSeparatorExists(): void
    {
        $segments = ['foo', 'bar', 'baz'];

        $path = implode(Path::getSeparator(), $segments);
        $path = Path::getSeparator() . $path;

        $expected = (new Path($segments))->setHasLeadingSeparator(true);
        $actual   = (new Parse())($path);

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeIfTrailingSeparatorExists(): void
    {
        $segments = ['foo', 'bar', 'baz'];

        $path = implode(Path::getSeparator(), $segments);
        $path .= Path::getSeparator();

        $expected = (new Path($segments))->setHasTrailingSeparator(true);
        $actual   = (new Parse())($path);

        $this->assertEquals($expected, $actual);

        return;
    }
}
