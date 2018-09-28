<?php
/**
 * The file for the get-definition service tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Definition\Service;

use Jstewmc\Gravity\Cache\Data\Cache;
use Jstewmc\Gravity\Id\Data\{
    Id,
    Service as ServiceId,
    Setting as SettingId
};
use Jstewmc\Gravity\Id\Service\Find as FindId;
use Jstewmc\Gravity\Project\Data\Project;
use Jstewmc\Gravity\Service\Service\Get as GetService;
use Jstewmc\Gravity\Setting\Service\Get as GetSetting;
use PHPUnit\Framework\TestCase;
use StdClass;

/**
 * Tests for the get-definition service
 *
 * @since  0.1.0
 */
class GetTest extends TestCase
{
    public function testInvokeIfIdIsCached(): void
    {
        // stub the project
        $project = $this->createMock(Project::class);

        // stub the find-id service to return an id
        $id = $this->createMock(Id::class);

        $findId = $this->createMock(FindId::class);
        $findId->method('__invoke')->willReturn($id);

        // stub the get-service and get-setting services (no expectations)
        $getService = $this->createMock(GetService::class);
        $getSetting = $this->createMock(GetSetting::class);

        // stub the cache to return an instance
        $instance = $this->createMock(StdClass::class);

        $cache = $this->createMock(Cache::class);
        $cache->method('has')->willReturn(true);
        $cache->method('get')->willReturn($instance);

        // instantiate the system-under-test
        $sut = new Get($findId, $getService, $getSetting, $cache);

        $expected = $instance;
        $actual   = $sut('foo', $project);

        $this->assertSame($expected, $actual);

        return;
    }

    public function testInvokeIfIdIsService(): void
    {
        // stub the cache to return false
        $cache = $this->createMock(Cache::class);
        $cache->method('has')->willReturn(false);

        // stub the project
        $project = $this->createMock(Project::class);

        // stub the find-id service to return an id
        $id = $this->createMock(ServiceId::class);

        $findId = $this->createMock(FindId::class);
        $findId->method('__invoke')->willReturn($id);

        // stub the get-service to return an instance
        $instance = $this->createMock(StdClass::class);

        $getService = $this->createMock(GetService::class);
        $getService->method('__invoke')->willReturn($instance);

        // stub the get-setting with no expectations
        $getSetting = $this->createMock(GetSetting::class);

        // instantiate the system-under-test
        $sut = new Get($findId, $getService, $getSetting, $cache);

        $expected = $instance;
        $actual   = $sut('foo', $project);

        $this->assertSame($expected, $actual);

        return;
    }

    public function testInvokeIfIdIsSetting(): void
    {
        // stub the cache to return false
        $cache = $this->createMock(Cache::class);
        $cache->method('has')->willReturn(false);

        // stub the project
        $project = $this->createMock(Project::class);

        // stub the find-id service to return an id
        $id = $this->createMock(SettingId::class);

        $findId = $this->createMock(FindId::class);
        $findId->method('__invoke')->willReturn($id);

        // stub the get-service with no expectations
        $getService = $this->createMock(GetService::class);

        // stub the get-setting service to return a value
        $value = 1;

        $getSetting = $this->createMock(GetSetting::class);
        $getSetting->method('__invoke')->willReturn($value);

        // instantiate the system-under-test
        $sut = new Get($findId, $getService, $getSetting, $cache);

        $expected = $value;
        $actual   = $sut('foo', $project);

        $this->assertSame($expected, $actual);

        return;
    }
}
