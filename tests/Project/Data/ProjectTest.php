<?php
/**
 * The file for the project tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Project\Data;

use Jstewmc\Gravity\Alias\Data\Alias;
use Jstewmc\Gravity\Alias\Exception\NotFound as AliasNotFound;
use Jstewmc\Gravity\Deprecation\Data\Deprecation;
use Jstewmc\Gravity\Deprecation\Exception\NotFound as DeprecationNotFound;
use Jstewmc\Gravity\Id\Data\Id;
use Jstewmc\Gravity\Id\Data\Service as ServiceId;
use Jstewmc\Gravity\Id\Data\Setting as SettingId;
use Jstewmc\Gravity\Path\Data\Setting as SettingPath;
use Jstewmc\Gravity\Service\Data\Service;
use Jstewmc\Gravity\Service\Exception\NotFound as ServiceNotFound;
use Jstewmc\Gravity\Setting\Data\Setting;
use Jstewmc\Gravity\Setting\Exception\NotFound as SettingNotFound;
use PHPUnit\Framework\TestCase;

/**
 * Tests for a project
 *
 * @since  0.1.0
 * @todo
 */
class ProjectTest extends TestCase
{
    /* addX() methods */

    public function testAddAlias(): void
    {
        $alias = $this->createMock(Alias::class);

        $project = new Project();

        $this->assertSame($project, $project->addAlias($alias));

        return;
    }

    public function testAddDeprecation(): void
    {
        $deprecation = $this->createMock(Deprecation::class);

        $project = new Project();

        $this->assertSame($project, $project->addDeprecation($deprecation));

        return;
    }

    public function testAddService(): void
    {
        $service = $this->createMock(Service::class);

        $project = new Project();

        $this->assertSame($project, $project->addService($service));

        return;
    }

    public function testAddSetting(): void
    {
        $setting = $this->createMock(Setting::class);
        $setting->method('getArray')->willReturn([]);

        $project = new Project();

        $this->assertSame($project, $project->addSetting($setting));

        return;
    }


    /* !getX() methods */

    public function testGetAliasThrowsExceptionIfDoesNotExist(): void
    {
        $this->expectException(AliasNotFound::class);

        $id = $this->createMock(Id::class);

        (new Project())->getAlias($id);

        return;
    }

    public function testGetAliasReturnsAliasIfDoesExist(): void
    {
        $id = $this->createMock(Id::class);
        $id->method('__toString')->willReturn('foo');

        $alias = $this->createMock(Alias::class);
        $alias->method('getSource')->willReturn($id);

        $project = (new Project())->addAlias($alias);

        $this->assertSame($alias, $project->getAlias($id));

        return;
    }

    public function testGetDeprecationThrowsExceptionIfDoesNotExist(): void
    {
        $this->expectException(DeprecationNotFound::class);

        $id = $this->createMock(Id::class);

        (new Project())->getDeprecation($id);

        return;
    }

    public function testGetDeprecationReturnsDeprecationIfDoesExist(): void
    {
        $id = $this->createMock(Id::class);
        $id->method('__toString')->willReturn('foo');

        $deprecation = $this->createMock(Deprecation::class);
        $deprecation->method('getId')->willReturn($id);

        $project = (new Project())->addDeprecation($deprecation);

        $this->assertSame($deprecation, $project->getDeprecation($id));

        return;
    }

    public function testGetServiceThrowsExceptionIfDoesNotExist(): void
    {
        $this->expectException(ServiceNotFound::class);

        $id = $this->createMock(ServiceId::class);

        (new Project())->getService($id);

        return;
    }

    public function testGetServiceReturnsServiceIfDoesExist(): void
    {
        $id = $this->createMock(ServiceId::class);
        $id->method('__toString')->willReturn('foo');

        $service = $this->createMock(Service::class);
        $service->method('getId')->willReturn($id);

        $project = (new Project())->addService($service);

        $this->assertSame($service, $project->getService($id));

        return;
    }

    public function testGetSettingThrowsExceptionIfDoesNotExist(): void
    {
        $this->expectException(SettingNotFound::class);

        $path = $this->createMock(SettingPath::class);
        $path->method('getSegments')->willReturn(['foo', 'bar', 'baz']);

        $id = $this->createMock(SettingId::class);
        $id->method('getPath')->willReturn($path);

        (new Project())->getSetting($id);

        return;
    }

    public function testGetSettingReturnsSettingIfDoesExist(): void
    {
        $path = $this->createMock(SettingPath::class);
        $path->method('getSegments')->willReturn(['foo', 'bar', 'baz']);

        $id = $this->createMock(SettingId::class);
        $id->method('__toString')->willReturn('foo.bar.baz');
        $id->method('getPath')->willReturn($path);

        $setting = $this->createMock(Setting::class);
        $setting->method('getId')->willReturn($id);
        $setting->method('getArray')->willReturn(['foo' => ['bar' => ['baz' => 1]]]);

        $project = (new Project())->addSetting($setting);

        $this->assertEquals(1, $project->getSetting($id));

        return;
    }


    /* !hasX() methods */

    public function testHasAliasReturnsFalseIfDoesNotExist(): void
    {
        $id = $this->createMock(Id::class);

        $this->assertFalse((new Project())->hasAlias($id));

        return;
    }

    public function testHasAliasReturnsTrueIfDoesExist(): void
    {
        $id = $this->createMock(Id::class);
        $id->method('__toString')->willReturn('foo');

        $alias = $this->createMock(Alias::class);
        $alias->method('getSource')->willReturn($id);

        $project = (new Project())->addAlias($alias);

        $this->assertTrue($project->hasAlias($id));

        return;
    }

    public function testHasDeprecationReturnsFalseIfDoesNotExist(): void
    {
        $id = $this->createMock(Id::class);

        $this->assertFalse((new Project())->hasDeprecation($id));

        return;
    }

    public function testHasDeprecationReturnsTrueIfDoesExist(): void
    {
        $id = $this->createMock(Id::class);
        $id->method('__toString')->willReturn('foo');

        $deprecation = $this->createMock(Deprecation::class);
        $deprecation->method('getId')->willReturn($id);

        $project = (new Project())->addDeprecation($deprecation);

        $this->assertTrue($project->hasDeprecation($id));

        return;
    }

    public function testHasServiceReturnsFalseIfDoesNotExist(): void
    {
        $id = $this->createMock(Id::class);

        $this->assertFalse((new Project())->hasService($id));

        return;
    }

    public function testHasServiceReturnsTrueIfDoesExist(): void
    {
        $id = $this->createMock(Id::class);
        $id->method('__toString')->willReturn('foo');

        $service = $this->createMock(Service::class);
        $service->method('getId')->willReturn($id);

        $project = (new Project())->addService($service);

        $this->assertTrue($project->hasService($id));

        return;
    }

    public function testHasSettingReturnsFalseIfDoesNotExist(): void
    {
        $path = $this->createMock(SettingPath::class);
        $path->method('getSegments')->willReturn(['foo', 'bar', 'baz']);

        $id = $this->createMock(Id::class);
        $id->method('getPath')->willReturn($path);

        $this->assertFalse((new Project())->hasSetting($id));

        return;
    }

    public function testHasSettingReturnsTrueIfDoesExist(): void
    {
        $path = $this->createMock(SettingPath::class);
        $path->method('getSegments')->willReturn(['foo', 'bar', 'baz']);

        $id = $this->createMock(SettingId::class);
        $id->method('__toString')->willReturn('foo.bar.baz');
        $id->method('getPath')->willReturn($path);

        $setting = $this->createMock(Setting::class);
        $setting->method('getId')->willReturn($id);
        $setting->method('getArray')->willReturn(['foo' => ['bar' => ['baz' => 1]]]);

        $project = (new Project())->addSetting($setting);

        $this->assertTrue($project->hasSetting($id));

        return;
    }
}
