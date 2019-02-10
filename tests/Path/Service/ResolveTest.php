<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Path\Service;

use Jstewmc\Gravity\Id\Data\{
    Service as ServiceId,
    Setting as SettingId
};
use Jstewmc\Gravity\Ns\Data\Parsed as Ns;
use Jstewmc\Gravity\Path\Data\{
    Service as ServicePath,
    Setting as SettingPath
};
use PHPUnit\Framework\TestCase;

/**
 * @group  path
 */
class ResolveTest extends TestCase
{
    public function testInvokeIfNamespaceIsEmpty(): void
    {
        // three segments are required to pass validations
        $path = $this->createMock(ServicePath::class);
        $path->method('getLength')->willReturn(3);

        // stub an empty namespace
        $namespace = $this->createMock(Ns::class);
        $namespace->method('isEmpty')->willReturn(true);

        $merge = $this->createMock(Merge::class);

        $sut = new Resolve($merge);

        $expected = new ServiceId($path);
        $actual   = $sut($path, $namespace);

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeIfPathIsFullyQualified(): void
    {
        // stub a fully-qualified path (i.e., has a leading separator)
        $path = $this->createMock(ServicePath::class);
        $path->method('hasLeadingSeparator')->willReturn(true);
        $path->method('getLength')->willReturn(3);

        // stub a non-empty namespace
        $namespace = $this->createMock(Ns::class);
        $namespace->method('isEmpty')->willReturn(false);

        $merge = $this->createMock(Merge::class);

        $sut = new Resolve($merge);

        $expected = new ServiceId($path);
        $actual   = $sut($path, $namespace);

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeIfPathIsIdentifier(): void
    {
        // stub a non-empty path that is not fully-qualified
        $path = $this->createMock(ServicePath::class);
        $path->method('hasLeadingSeparator')->willReturn(false);
        $path->method('getLength')->willReturn(3);
        $path->method('getFirstSegment')->willReturn('foo');

        // stub a non-empty namespace without a name
        $namespace = $this->createMock(Ns::class);
        $namespace->method('isEmpty')->willReturn(false);
        $namespace->method('hasImport')->willReturn(false);
        $namespace->method('hasName')->willReturn(false);

        $merge = $this->createMock(Merge::class);

        $sut = new Resolve($merge);

        $expected = new ServiceId($path);
        $actual   = $sut($path, $namespace);

        $this->assertEquals($expected, $actual);

        return;
    }

    // public function testInvokeIfPathIsRelative(): void
    // {
    //     // hmm, can we do this without stubbing the entire world?!
    // }

    // public function testInvokeIfNamespaceHasName(): void
    // {
    //     // hmm, can we do this without stubbing the entire world?!
    // }
}
