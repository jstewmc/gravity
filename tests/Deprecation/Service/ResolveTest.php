<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Service;

use Jstewmc\Gravity\Deprecation\Data\{Parsed, Resolved};
use Jstewmc\Gravity\Id\Data\Id;
use Jstewmc\Gravity\Ns\Data\Parsed as Ns;
use Jstewmc\Gravity\Path\Data\Path;
use Jstewmc\Gravity\Path\Service\Resolve as ResolvePath;
use PHPUnit\Framework\TestCase;

/**
 * @group  deprecation
 */
class ResolveTest extends TestCase
{
    public function testInvokeIfReplacementDoesNotExist(): void
    {
        // set up the resolve-path service
        $source = $this->mockSource();

        $resolvePath = $this->createMock(ResolvePath::class);
        $resolvePath->method('__invoke')->willReturn($source);

        // set up the system-under-test
        $sut = new Resolve($resolvePath);

        // // set up expectations
        $deprecation = $this->createMock(Parsed::class);
        $deprecation->method('hasReplacement')->willReturn(false);

        $namespace = $this->createMock(Ns::class);

        $expected = new Resolved($source);
        $actual   = $sut($deprecation, $namespace);

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeIfReplacementDoesExist(): void
    {
        // set up the resolve-path service
        $source      = $this->mockSource();
        $replacement = $this->mockReplacement();

        $resolvePath = $this->createMock(ResolvePath::class);
        $resolvePath
            ->method('__invoke')
            ->will($this->onConsecutiveCalls($source, $replacement));

        // set up the system-under-test
        $sut = new Resolve($resolvePath);

        // set up expectations
        $path = $this->createMock(Path::class);

        $deprecation = $this->createMock(Parsed::class);
        $deprecation->method('hasReplacement')->willReturn(true);
        $deprecation->method('getReplacement')->willReturn($path);

        $namespace = $this->createMock(Ns::class);

        $expected = new Resolved($source, $replacement);
        $actual   = $sut($deprecation, $namespace);

        $this->assertEquals($expected, $actual);

        return;
    }

    private function mockReplacement($id = 'bar')
    {
        $replacement = $this->createMock(Id::class);
        $replacement->method('__toString')->willReturn($id);

        return $replacement;
    }

    private function mockSource($id = 'foo')
    {
        $source = $this->createMock(Id::class);
        $source->method('__toString')->willReturn($id);

        return $source;
    }
}
