<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Service;

use Jstewmc\Gravity\Deprecation\Data\{Parsed, Read};
use Jstewmc\Gravity\Path\Data\Path;
use Jstewmc\Gravity\Path\Service\Parse as ParsePath;
use PHPUnit\Framework\TestCase;

/**
 * @group  deprecation
 */
class ParseTest extends TestCase
{
    public function testInvokeIfReplacementDoesNotExist(): void
    {
        // set up a path for the parse-path servie to return
        $source = $this->mockSource();

        // set up the parse-path service to return path
        $parsePath = $this->createMock(ParsePath::class);
        $parsePath->method('__invoke')->willReturn($source);

        // set up the system-under-test
        $sut = new Parse($parsePath);

        // set up a throwaway input deprecation
        $deprecation = $this->createMock(Read::class);
        $deprecation->method('hasReplacement')->willReturn(false);

        // set up expectations
        $expected = new Parsed($source);
        $actual   = $sut($deprecation);

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeIfReplacementDoesExist(): void
    {
        // set up paths for the parse-path service to return
        $source      = $this->mockSource();
        $replacement = $this->mockReplacement();

        // set up the parse-identifier service
        $parsePath = $this->createMock(ParsePath::class);
        $parsePath
            ->method('__invoke')
            ->will($this->onConsecutiveCalls($source, $replacement));

        // set up the system-under-test
        $sut = new Parse($parsePath);

        // set up a read deprecation input
        $deprecation = $this->createMock(Read::class);
        $deprecation->method('hasReplacement')->willReturn(true);
        $deprecation->method('getReplacement')->willReturn('baz');

        // set up expectations
        $expected = new Parsed($source, $replacement);
        $actual   = $sut($deprecation);

        $this->assertEquals($expected, $actual);

        return;
    }

    private function mockReplacement($path = 'bar')
    {
        $replacement = $this->createMock(Path::class);
        $replacement->method('__toString')->willReturn($path);

        return $replacement;
    }

    private function mockSource($path = 'foo')
    {
        $source = $this->createMock(Path::class);
        $source->method('__toString')->willReturn($path);

        return $source;
    }
}
