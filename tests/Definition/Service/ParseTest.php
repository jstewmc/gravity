<?php
/**
 * The file for the parse-definition service tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Definition\Service;

use Jstewmc\Gravity\Id\Data\{
    Service as ServiceId,
    Setting as SettingId
};
use Jstewmc\Gravity\Id\Service\Parse as ParseId;
use Jstewmc\Gravity\Service\Service\Parse as ParseService;
use Jstewmc\Gravity\Setting\Service\Parse as ParseSetting;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the parse-definition service
 *
 * @since  0.1.0
 */
class ParseTest extends TestCase
{
    public function testInvokeReturnsServiceIfService(): void
    {
        $id = $this->createMock(ServiceId::class);
        $value      = function () { return; };

        // stub the parse-identifier service to return the identifier
        $parseId = $this->createMock(ParseId::class);
        $parseId->method('__invoke')->willReturn($id);

        // stub the parse-setting service, because it shouldn't be called
        $parseSetting = $this->createMock(ParseSetting::class);

        // mock the parse-service service to expect a call
        $parseService = $this->getMockBuilder(ParseService::class)
            ->setMethods(['__invoke'])
            ->getMock();

        $parseService
            ->expects($this->once())
            ->method('__invoke')
            ->with($id, $value);

        // instantiate the system-under-test
        $sut = new Parse($parseId, $parseService, $parseSetting);

        $sut($id, $value);

        return;
    }

    public function testInvokeReturnsSettingIfSetting(): void
    {
        $id = $this->createMock(SettingId::class);
        $value      = 'foo';

        // stub the parse-identifier service to return the identifier
        $parseId = $this->createMock(ParseId::class);
        $parseId->method('__invoke')->willReturn($id);

        // stub the parse-service service, because it shouldn't be called
        $parseService = $this->createMock(ParseService::class);

        // mock the parse-setting service to expect a call
        $parseSetting = $this->getMockBuilder(ParseSetting::class)
            ->setMethods(['__invoke'])
            ->getMock();

        $parseSetting
            ->expects($this->once())
            ->method('__invoke')
            ->with($id, $value);

        // instantiate the system-under-test
        $sut = new Parse($parseId, $parseService, $parseSetting);

        $sut($id, $value);

        return;
    }
}
