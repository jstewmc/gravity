<?php
/**
 * The file for the parse-id service tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Service;

use Jstewmc\Gravity\Id\Data\Service as ServiceId;
use Jstewmc\Gravity\Id\Data\Setting as SettingId;
use Jstewmc\Gravity\Id\Exception\BadLength;
use Jstewmc\Gravity\Path\Data\Service as ServicePath;
use Jstewmc\Gravity\Path\Data\Setting as SettingPath;
use Jstewmc\Gravity\Path\Service\Parse as ParsePath;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the parse-id service
 *
 * @since  0.1.0
 */
class ParseTest extends TestCase
{
    public function testInvokeThrowsExceptionIfIdTooShort(): void
    {
        $this->expectException(BadLength::class);

        // stub the parse-path service to return a service path that's too short
        $path = $this->createMock(ServicePath::class);
        $path->method('getLength')->willReturn(1);

        $parsePath = $this->createMock(ParsePath::class);
        $parsePath->method('__invoke')->willReturn($path);

        (new Parse($parsePath))('foo');

        return;
    }

    public function testInvokeReturnsIdIfService(): void
    {
        // stub the parse-path service to return a valid service path
        $path = $this->createMock(ServicePath::class);
        $path->method('getLength')->willReturn(3);

        $parsePath = $this->createMock(ParsePath::class);
        $parsePath->method('__invoke')->willReturn($path);

        $expected = new ServiceId($path);
        $actual   = (new Parse($parsePath))('foo');

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeReturnsIdIfSetting(): void
    {
        // stub the parse-path service to return a valid setting path
        $path = $this->createMock(SettingPath::class);
        $path->method('getLength')->willReturn(3);

        $parsePath = $this->createMock(ParsePath::class);
        $parsePath->method('__invoke')->willReturn($path);

        $expected = new SettingId($path);
        $actual   = (new Parse($parsePath))('foo');

        $this->assertEquals($expected, $actual);

        return;
    }
}
