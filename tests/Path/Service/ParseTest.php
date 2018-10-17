<?php
/**
 * The file for the parse-path tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Path\Service;

use Jstewmc\Gravity\Path\Data\Setting as Path;
use Jstewmc\Gravity\Path\Exception\BadLength;
use Jstewmc\Gravity\Path\Exception\BadSeparator;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the parse-path service
 *
 * @since  0.1.0
 */
class ParseTest extends TestCase
{
    public function testInvokeThrowsExceptionIfBadSeparator(): void
    {
        $this->expectException(BadSeparator::class);

        (new Parse())('foo-bar-baz');

        return;
    }

    public function testInvokeThrowsExceptionIfBadLengthBeforeParsing(): void
    {
        $this->expectException(BadLength::class);

        (new Parse())('');

        return;
    }

    public function testInvokeThrowsExceptionIfBadLengthAfterParsing(): void
    {
        $this->expectException(BadLength::class);

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

        $expected = new Path($segments);
        $actual   = (new Parse())($path);

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeReturnsIdIfTrailingSeparatorExists(): void
    {
        $segments = ['foo', 'bar', 'baz'];

        $path = implode(Path::SEPARATOR, $segments);
        $path = $path . Path::SEPARATOR;

        $expected = new Path($segments);
        $actual   = (new Parse())($path);

        $this->assertEquals($expected, $actual);

        return;
    }
}
