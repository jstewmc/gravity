<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity;

use Jstewmc\Gravity\{Id, Ns, Project, Service, Setting};
use PHPUnit\Framework\TestCase;
use StdClass;

/**
 * @group  manager
 */
class ManagerTest extends TestCase
{
    public function testEnter()
    {
        $namespace = $this->createMock(Ns\Data\Parsed::class);

        $manager = new Manager(
            $this->createMock(Project\Data\Project::class),
            $this->createMock(Id\Service\Get::class),
            $this->createMock(Service\Service\Get::class),
            $this->createMock(Setting\Service\Get::class)
        );

        $this->assertNull($manager->enter($namespace));
    }

    public function testExit()
    {
        $namespace = $this->createMock(Ns\Data\Parsed::class);

        $manager = new Manager(
            $this->createMock(Project\Data\Project::class),
            $this->createMock(Id\Service\Get::class),
            $this->createMock(Service\Service\Get::class),
            $this->createMock(Setting\Service\Get::class)
        );

        $manager->enter($namespace);

        $this->assertNull($manager->exit());
    }

    public function testGetSetting(): void
    {
        $path  = 'foo.bar.baz';
        $value = 1;

        $id    = $this->createMock(Id\Data\Setting::class);
        $getId = $this->createMock(Id\Service\Get::class);
        $getId->method('__invoke')->willReturn($id);

        $getService = $this->createMock(Service\Service\Get::class);

        $getSetting = $this->createMock(Setting\Service\Get::class);
        $getSetting->method('__invoke')->willReturn($value);

        $project = $this->createMock(Project\Data\Project::class);

        $g = new Manager($project, $getId, $getService, $getSetting);

        $expected = $value;
        $actual   = $g->get($path);

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testGetService(): void
    {
        $path     = 'Foo\Bar\Baz';
        $instance = new StdClass();

        $id    = $this->createMock(Id\Data\Service::class);
        $getId = $this->createMock(Id\Service\Get::class);
        $getId->method('__invoke')->willReturn($id);

        $getService = $this->createMock(Service\Service\Get::class);
        $getService->method('__invoke')->willReturn($instance);

        $getSetting = $this->createMock(Setting\Service\Get::class);

        $project = $this->createMock(Project\Data\Project::class);

        $g = new Manager($project, $getId, $getService, $getSetting);

        $expected = $instance;
        $actual   = $g->get($path);

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testHasIfServiceDoesExist(): void
    {
        $id = $this->createMock(Id\Data\Service::class);

        $getId = $this->createMock(Id\Service\Get::class);
        $getId->method('__invoke')->willReturn($id);

        $getService = $this->createMock(Service\Service\Get::class);
        $getSetting = $this->createMock(Setting\Service\Get::class);

        $project = $this->createMock(Project\Data\Project::class);
        $project->method('hasService')->willReturn(true);

        $g = new Manager($project, $getId, $getService, $getSetting);

        $this->assertTrue($g->has('Foo\Bar\Baz'));
    }

    public function testHasIfServiceDoesNotExist(): void
    {
        $id = $this->createMock(Id\Data\Service::class);

        $getId = $this->createMock(Id\Service\Get::class);
        $getId->method('__invoke')->willReturn($id);

        $getService = $this->createMock(Service\Service\Get::class);
        $getSetting = $this->createMock(Setting\Service\Get::class);

        $project = $this->createMock(Project\Data\Project::class);
        $project->method('hasService')->willReturn(false);

        $g = new Manager($project, $getId, $getService, $getSetting);

        $this->assertFalse($g->has('Foo\Bar\Baz'));
    }

    public function testHasIfSettingDoesExist(): void
    {
        $id = $this->createMock(Id\Data\Setting::class);

        $getId = $this->createMock(Id\Service\Get::class);
        $getId->method('__invoke')->willReturn($id);

        $getService = $this->createMock(Service\Service\Get::class);
        $getSetting = $this->createMock(Setting\Service\Get::class);

        $project = $this->createMock(Project\Data\Project::class);
        $project->method('hasSetting')->willReturn(true);

        $g = new Manager($project, $getId, $getService, $getSetting);

        $this->assertTrue($g->has('foo.bar.baz'));
    }

    public function testHasIfSettingDoesNotExist(): void
    {
        $id = $this->createMock(Id\Data\Setting::class);

        $getId = $this->createMock(Id\Service\Get::class);
        $getId->method('__invoke')->willReturn($id);

        $getService = $this->createMock(Service\Service\Get::class);
        $getSetting = $this->createMock(Setting\Service\Get::class);

        $project = $this->createMock(Project\Data\Project::class);
        $project->method('hasSetting')->willReturn(false);

        $g = new Manager($project, $getId, $getService, $getSetting);

        $this->assertFalse($g->has('foo.bar.baz'));
    }
}
