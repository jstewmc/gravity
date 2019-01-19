<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Path\Service;

use Jstewmc\Gravity\Path\Data\Setting as Path;
use Jstewmc\Gravity\Path\Exception\{EmptyPath, InvalidSeparator};
use PHPUnit\Framework\TestCase;

/**
 * @group  path
 */
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

    public function testInvokeReturnsIdIfWhitespaceExists(): void
    {
        $segments = ['foo', 'bar', 'baz'];

        $path = implode(Path::SEPARATOR, $segments);
        $path = "   $path   ";

        $expected = new Path($segments);
        $actual   = (new Parse())($path);

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeReturnsIdIfMixedCaseExists(): void
    {
        $segments = ['FOO', 'bar', 'BaZ'];

        $path = implode(Path::SEPARATOR, $segments);

        $expected = new Path(['foo', 'bar', 'baz']);
        $actual   = (new Parse())($path);

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeReturnsIdIfEmptySegmentsExist(): void
    {
        $segments = ['foo', null, 'bar', 'baz'];

        $path = implode(Path::SEPARATOR, $segments);

        $expected = new Path(['foo', 'bar', 'baz']);
        $actual   = (new Parse())($path);

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeReturnsIdIfLeadingSeparatorExists(): void
    {
        $segments = ['foo', 'bar', 'baz'];

        $path = implode(Path::SEPARATOR, $segments);
        $path = Path::SEPARATOR . $path;

        $expected = (new Path($segments))->setHasLeadingSeparator(true);
        $actual   = (new Parse())($path);

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeReturnsIdIfTrailingSeparatorExists(): void
    {
        $segments = ['foo', 'bar', 'baz'];

        $path = implode(Path::SEPARATOR, $segments);
        $path = $path . Path::SEPARATOR;

        $expected = (new Path($segments))->setHasTrailingSeparator(true);
        $actual   = (new Parse())($path);

        $this->assertEquals($expected, $actual);

        return;
    }
}
