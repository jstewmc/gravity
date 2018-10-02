<?php
/**
 * The file for the parse-deprecation service tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Service;

use Jstewmc\Gravity\Deprecation\Data\Service as ServiceDeprecation;
use Jstewmc\Gravity\Deprecation\Data\Setting as SettingDeprecation;
use Jstewmc\Gravity\Deprecation\Exception\Circular;
use Jstewmc\Gravity\Id\Data\Id;
use Jstewmc\Gravity\Id\Data\Service as ServiceId;
use Jstewmc\Gravity\Id\Data\Setting as SettingId;
use Jstewmc\Gravity\Id\Service\Parse as ParseId;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the parse-deprecation service
 *
 * @since  0.1.0
 */
class ParseTest extends TestCase
{
    public function testInvokeThrowsExceptionIfCircular(): void
    {
        $this->expectException(Circular::class);

        // set up identifier and replacement identifiers
        $id = $this->createMock(Id::class);
        $id->method('__toString')->willReturn('foo');

        $replacement = $this->createMock(Id::class);
        $replacement->method('__toString')->willReturn('foo');

        // set up the parse-identifier service
        $parseId = $this->createMock(ParseId::class);
        $parseId
            ->method('__invoke')
            ->will($this->onConsecutiveCalls($id, $replacement));

        // instantiate the system under test
        $sut = new Parse($parseId);

        $sut('foo', 'foo');

        return;
    }

    public function testInvokeReturnsDeprecationIfService(): void
    {
        // set up identifier and replacement _service_ identifiers
        $id = $this->createMock(ServiceId::class);
        $id->method('__toString')->willReturn('foo\bar\baz');

        $replacement = $this->createMock(ServiceId::class);
        $replacement->method('__toString')->willReturn('foo\bar\qux');

        // set up the parse-identifier service
        $parseId = $this->createMock(ParseId::class);
        $parseId
            ->method('__invoke')
            ->will($this->onConsecutiveCalls($id, $replacement));

        // instantiate the system under test
        $sut = new Parse($parseId);

        // instantiate the system under test
        $expected = new ServiceDeprecation($id, $replacement);
        $actual   = $sut('foo\bar\baz', 'foo\bar\qux');

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeReturnsDeprecationIfSetting(): void
    {
        // set up identifier and replacement _setting_ identifiers
        $id = $this->createMock(SettingId::class);
        $id->method('__toString')->willReturn('foo.bar.baz');

        $replacement = $this->createMock(SettingId::class);
        $replacement->method('__toString')->willReturn('foo.bar.qux');

        // set up the parse-identifier service
        $parseId = $this->createMock(ParseId::class);
        $parseId
            ->method('__invoke')
            ->will($this->onConsecutiveCalls($id, $replacement));

        // instantiate the system under test
        $sut = new Parse($parseId);

        // instantiate the system under test
        $expected = new SettingDeprecation($id, $replacement);
        $actual   = $sut('foo.bar.baz', 'foo.bar.qux');

        $this->assertEquals($expected, $actual);

        return;
    }
}
