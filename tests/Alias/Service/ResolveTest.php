<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Alias\Service;

use Jstewmc\Gravity\Alias\Data\{Parsed, Resolved};
use Jstewmc\Gravity\Alias\Service\Resolve;
use Jstewmc\Gravity\Id\Data\Id;
use Jstewmc\Gravity\Ns\Data\Parsed as ParsedNs;
use Jstewmc\Gravity\Path\Service\Resolve as ResolvePath;
use PHPUnit\Framework\TestCase;

class ResolveTest extends TestCase
{
    public function testInvoke(): void
    {
        // set up identifiers for the resolve-path service to return
        $source = $this->createMock(Id::class);
        $source->method('__toString')->willReturn('foo\bar\baz');

        $destination = $this->createMock(Id::class);
        $destination->method('__toString')->willReturn('foo\bar\qux');

        // set up the resolve-path service to return the ids
        $resolvePath = $this->createMock(ResolvePath::class);
        $resolvePath
            ->method('__invoke')
            ->will($this->onConsecutiveCalls($source, $destination));

        // instantiate the system under test
        $sut = new Resolve($resolvePath);

        // set up a parsed alias and namespace throwaway arguments
        $alias     = $this->createMock(Parsed::class);
        $namespace = $this->createMock(ParsedNs::class);

        // instantiate the system under test (inputs don't matter)
        $expected = new Resolved($source, $destination);
        $actual   = $sut($alias, $namespace);

        $this->assertEquals($expected, $actual);

        return;
    }
}
