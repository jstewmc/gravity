<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Project\Service;

use Jstewmc\Gravity\Exception;
use Jstewmc\Gravity\Id\Data\{
    Service as ServiceId,
    Setting as SettingId
};
use Jstewmc\Gravity\Manager\Data\Manager;
use Jstewmc\Gravity\Project\Data\Project;
use Jstewmc\Gravity\Requirement\Data\Resolved as Requirement;
use Jstewmc\Gravity\Service\Data\Service;
use Jstewmc\Gravity\Service\Service\Instantiate;
use PHPUnit\Framework\TestCase;

class ValidateTest extends TestCase
{
    private $manager;

    public function setUp(): void
    {
        $this->manager = $this->createMock(Manager::class);
    }

    public function testInvokeIfProjectIsValid(): void
    {
        $project = $this->createMock(Project::class);
        $project->method('getRequirements')->willReturn([]);
        $project->method('getServices')->willReturn([]);

        $instantiate = $this->createMock(Instantiate::class);

        $sut = new Validate($instantiate);

        $this->assertEmpty($sut($project, $this->manager));
    }

    public function testInvokeIfServiceRequirementIsInvalid(): void
    {
        $key = 'foo\bar\baz';

        $id = $this->createMock(ServiceId::class);
        $id->method('__toString')->willReturn($key);

        $requirement = $this->createMock(Requirement::class);
        $requirement->method('isService')->willReturn(true);
        $requirement->method('getKey')->willReturn($id);

        $project = $this->createMock(Project::class);
        $project->method('getRequirements')->willReturn([$requirement]);
        $project->method('getServices')->willReturn([]);
        $project->method('hasService')->willReturn(false);

        $instantiate = $this->createMock(Instantiate::class);

        $sut = new Validate($instantiate);

        $this->assertArrayHasKey($key, $sut($project, $this->manager));
    }

    public function testInvokeIfSettingRequirementIsInvalid(): void
    {
        $key = 'foo.bar.baz';

        $id = $this->createMock(SettingId::class);
        $id->method('__toString')->willReturn($key);

        $requirement = $this->createMock(Requirement::class);
        $requirement->method('isService')->willReturn(false);
        $requirement->method('getKey')->willReturn($id);

        $project = $this->createMock(Project::class);
        $project->method('getRequirements')->willReturn([$requirement]);
        $project->method('getServices')->willReturn([]);
        $project->method('hasSetting')->willReturn(false);

        $instantiate = $this->createMock(Instantiate::class);

        $sut = new Validate($instantiate);

        $this->assertArrayHasKey($key, $sut($project, $this->manager));
    }

    public function testInvokeIfServiceDefinitionIsInvalid(): void
    {
        $key = 'foo\bar\baz';

        $id = $this->createMock(ServiceId::class);
        $id->method('__toString')->willReturn($key);

        $service = $this->createMock(Service::class);
        $service->method('getId')->willReturn($id);

        $project = $this->createMock(Project::class);
        $project->method('getRequirements')->willReturn([]);
        $project->method('getServices')->willReturn([$service]);

        $e = $this->createMock(Exception::class);

        $instantiate = $this->createMock(Instantiate::class);
        $instantiate->method('__invoke')->will($this->throwException($e));

        $sut = new Validate($instantiate);

        $this->assertArrayHasKey($key, $sut($project, $this->manager));
    }
}
