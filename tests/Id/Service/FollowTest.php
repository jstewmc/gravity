<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Service;

use Jstewmc\Gravity\Alias\Data\Resolved as Alias;
use Jstewmc\Gravity\Deprecation\Service\Warn as WarnDeprecation;
use Jstewmc\Gravity\Id\Data\Id;
use Jstewmc\Gravity\Project\Data\Project;
use PHPUnit\Framework\TestCase;

class FollowTest extends TestCase
{
    public function testInvokeReturnsIdIfNeitherDeprecatedNorAlias(): void
    {
        $id = $this->createMock(Id::class);

        $project = $this->createMock(Project::class);
        $project->method('hasDeprecation')->willReturn(false);
        $project->method('hasAlias')->willReturn(false);

        $warnDeprecation = $this->createMock(WarnDeprecation::class);

        $sut = new Follow($warnDeprecation);

        $expected = $id;
        $actual   = $sut($id, $project);

        $this->assertSame($expected, $actual);

        return;
    }

    public function testInvokeReturnsIdIfDeprecated(): void
    {
        $id = $this->createMock(Id::class);

        // stub the project to return deprecated
        $project = $this->createMock(Project::class);
        $project->method('hasDeprecation')->willReturn(true);
        $project->method('hasAlias')->willReturn(false);

        // mock the warn-deprecation service to expect a call
        $warnDeprecation = $this->getMockBuilder(WarnDeprecation::class)
            ->setMethods(['__invoke'])
            ->disableOriginalConstructor()
            ->getMock();

        $warnDeprecation->expects($this->once())->method('__invoke');

        $sut = new Follow($warnDeprecation);

        $expected = $id;
        $actual   = $sut($id, $project);

        $this->assertSame($expected, $actual);

        return;
    }

    public function testInvokeReturnsIdIfOneAlias(): void
    {
        // stub a source (i.e., the original identifier)
        $source = $this->createMock(Id::class);

        // stub a destination
        $destination = $this->createMock(Id::class);

        // stub an alias to return the destination
        $alias = $this->createMock(Alias::class);
        $alias->method('getDestination')->willReturn($destination);

        // stub the project for two consecutive calls
        $project = $this->createMock(Project::class);
        $project->method('hasDeprecation')->willReturn(false);
        $project->method('hasAlias')->will($this->onConsecutiveCalls(true, false));
        $project->method('getAlias')->willReturn($alias);

        // stub the warn-deprecation service (no expectations)
        $warnDeprecation = $this->createMock(WarnDeprecation::class);

        $sut = new Follow($warnDeprecation);

        $expected = $destination;
        $actual   = $sut($source, $project);

        $this->assertSame($expected, $actual);

        return;
    }

    public function testInvokeReturnsIdIfManyAliases(): void
    {
        // stub a source (i.e., the original identifier)
        $source = $this->createMock(Id::class);

        // stub a destination and alias
        $destination1 = $this->createMock(Id::class);

        $alias1 = $this->createMock(Alias::class);
        $alias1->method('getDestination')->willReturn($destination1);

        // stub a second destination and alias
        $destination2 = $this->createMock(Id::class);

        $alias2 = $this->createMock(Alias::class);
        $alias2->method('getDestination')->willReturn($destination2);

        // stub the project for consecutive calls
        $project = $this->createMock(Project::class);
        $project->method('hasDeprecation')->willReturn(false);

        $project->method('hasAlias')->will(
            $this->onConsecutiveCalls(true, true, false)
        );

        $project->method('getAlias')->will(
            $this->onConsecutiveCalls($alias1, $alias2)
        );

        // stub the warn-deprecation service (no expectations)
        $warnDeprecation = $this->createMock(WarnDeprecation::class);

        $sut = new Follow($warnDeprecation);

        $expected = $destination2;
        $actual   = $sut($source, $project);

        $this->assertSame($expected, $actual);

        return;
    }
}
