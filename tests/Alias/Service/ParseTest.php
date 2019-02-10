<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Alias\Service;

use Jstewmc\Gravity\Alias\Data\{Parsed, Read};
use Jstewmc\Gravity\Path\Data\Path;
use Jstewmc\Gravity\Path\Service\Parse as ParsePath;
use PHPUnit\Framework\TestCase;

class ParseTest extends TestCase
{
    public function testInvoke(): void
    {
        // set up paths for the parse-path service to return
        $source = $this->createMock(Path::class);
        $source->method('__toString')->willReturn('foo\bar\baz');

        $destination = $this->createMock(Path::class);
        $destination->method('__toString')->willReturn('foo\bar\qux');

        // stub the parse-path service to return the stubs above
        $parsePath = $this->createMock(ParsePath::class);
        $parsePath
            ->method('__invoke')
            ->will($this->onConsecutiveCalls($source, $destination));

        // instantiate the system under test
        $sut = new Parse($parsePath);

        // stub a read alias for input (doesn't matter)
        $alias = $this->createMock(Read::class);

        // set expectations and get result
        $expected = new Parsed($source, $destination);
        $actual   = $sut($alias);

        $this->assertEquals($expected, $actual);

        return;
    }
}
