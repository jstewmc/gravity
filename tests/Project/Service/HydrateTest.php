<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Project\Service;

use Jstewmc\Gravity\{
    Alias,
    Deprecation,
    File,
    Filesystem,
    Project,
    Service,
    Setting
};
use PHPUnit\Framework\TestCase;

/**
 * @group  project
 */
class HydrateTest extends TestCase
{
    public function testInvoke(): void
    {
        $alias       = $this->createMock(Alias\Data\Resolved::class);
        $deprecation = $this->createMock(Deprecation\Data\Resolved::class);
        $service     = $this->createMock(Service\Data\Service::class);
        $setting     = $this->createMock(Setting\Data\Setting::class);

        $file = $this->createMock(File\Data\Ran::class);
        $file->method('getAliases')->willReturn([$alias]);
        $file->method('getDeprecations')->willReturn([$deprecation]);
        $file->method('getServices')->willReturn([$service]);
        $file->method('getSettings')->willReturn([$setting]);

        $filesystem = $this->createMock(Filesystem\Data\Loaded::class);
        $filesystem->method('getFiles')->willReturn([$file]);

        $project = $this->getMockBuilder(Project\Data\Project::class)
            ->disableOriginalConstructor()
            ->setMethods(['addAlias', 'addDeprecation', 'addService', 'addSetting'])
            ->getMock();

        $project
            ->expects($this->once())
            ->method('addAlias')
            ->with($alias);

        $project
            ->expects($this->once())
            ->method('addDeprecation')
            ->with($deprecation);

        $project
            ->expects($this->once())
            ->method('addService')
            ->with($service);

        $project
            ->expects($this->once())
            ->method('addSetting')
            ->with($setting);

        $sut = new Hydrate();

        $sut($project, $filesystem);
    }
}
