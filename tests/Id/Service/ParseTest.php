<?php
/**
 * The file for the parse-identifier tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Service;

use Jstewmc\Gravity\Id\Data\Service as Id;  // either one works
use Jstewmc\Gravity\Id\Exception\{BadLength, BadSeparator};
use PHPUnit\Framework\TestCase;

/**
 * Tests for the parse-identifier service
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

    public function testInvokeThrowsExceptionIfBadLength(): void
    {
        $this->expectException(BadLength::class);

        (new Parse())(implode(Id::SEPARATOR, ['foo', 'bar']));

        return;
    }

    public function testInvokeReturnsIdIfWhitespaceExists(): void
    {
        $segments   = ['foo', 'bar', 'baz'];

        $id = implode(Id::SEPARATOR, $segments);

        $expected = new Id($segments);
        $actual   = (new Parse())("    $id    ");

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeReturnsIdIfMixedCaseExists(): void
    {
        $segments = ['FOO', 'bar', 'BaZ'];

        $id = implode(Id::SEPARATOR, $segments);

        $expected = new Id(['foo', 'bar', 'baz']);
        $actual   = (new Parse())($id);

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeReturnsIdIfEmptySegmentsExist(): void
    {
        $segments = ['foo', null, 'bar', 'baz'];

        $id = implode(Id::SEPARATOR, $segments);

        $expected = new Id(['foo', 'bar', 'baz']);
        $actual   = (new Parse())($id);

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeReturnsIdIfLeadingSeparatorExists(): void
    {
        $segments = ['foo', 'bar', 'baz'];

        $id = implode(Id::SEPARATOR, $segments);
        $id = Id::SEPARATOR . $id;

        $expected = new Id($segments);
        $actual   = (new Parse())($id);

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeReturnsIdIfTrailingSeparatorExists(): void
    {
        $segments = ['foo', 'bar', 'baz'];

        $id = implode(Id::SEPARATOR, $segments);
        $id = $id . Id::SEPARATOR;

        $expected = new Id($segments);
        $actual   = (new Parse())($id);

        $this->assertEquals($expected, $actual);

        return;
    }
}
