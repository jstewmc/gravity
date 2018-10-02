<?php
/**
 * The file for the parse-alias service tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Alias\Service;

use Jstewmc\Gravity\Alias\Data\Service as ServiceAlias;
use Jstewmc\Gravity\Alias\Data\Setting as SettingAlias;
use Jstewmc\Gravity\Alias\Exception\Circular;
use Jstewmc\Gravity\Id\Data\Id;
use Jstewmc\Gravity\Id\Data\Service as ServiceId;
use Jstewmc\Gravity\Id\Data\Setting as SettingId;
use Jstewmc\Gravity\Id\Service\Parse as ParseId;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the manager
 *
 * @since  0.1.0
 */
class ParseTest extends TestCase
{
    public function testInvokeThrowsExceptionIfCircular(): void
    {
        $this->expectException(Circular::class);

        // set up source and destination identifiers
        $source = $this->createMock(Id::class);
        $source->method('__toString')->willReturn('foo');

        $destination = $this->createMock(Id::class);
        $destination->method('__toString')->willReturn('foo');

        // set up the parse-identifier service
        $parseId = $this->createMock(ParseId::class);
        $parseId
            ->method('__invoke')
            ->will($this->onConsecutiveCalls($source, $destination));

        // instantiate the system under test
        $sut = new Parse($parseId);

        $sut('foo', 'foo');

        return;
    }

    public function testInvokeThrowsReturnsAliasIfService(): void
    {
        // set up source and destination _service_ identifiers
        $source = $this->createMock(ServiceId::class);
        $source->method('__toString')->willReturn('foo\bar\baz');

        $destination = $this->createMock(ServiceId::class);
        $destination->method('__toString')->willReturn('foo\bar\qux');

        // set up the parse-identifier service
        $parseId = $this->createMock(ParseId::class);
        $parseId
            ->method('__invoke')
            ->will($this->onConsecutiveCalls($source, $destination));

        // instantiate the system under test
        $sut = new Parse($parseId);

        // instantiate the system under test
        $expected = new ServiceAlias($source, $destination);
        $actual   = $sut('foo\bar\baz', 'foo\bar\qux');

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeThrowsReturnsAliasIfSetting(): void
    {
        // set up source and destination _setting_ identifiers
        $source = $this->createMock(SettingId::class);
        $source->method('__toString')->willReturn('foo.bar.baz');

        $destination = $this->createMock(SettingId::class);
        $destination->method('__toString')->willReturn('foo.bar.qux');

        // set up the parse-identifier service
        $parseId = $this->createMock(ParseId::class);
        $parseId
            ->method('__invoke')
            ->will($this->onConsecutiveCalls($source, $destination));

        // instantiate the system under test
        $sut = new Parse($parseId);

        // instantiate the system under test
        $expected = new SettingAlias($source, $destination);
        $actual   = $sut('foo.bar.baz', 'foo.bar.qux');

        $this->assertEquals($expected, $actual);

        return;
    }
}
