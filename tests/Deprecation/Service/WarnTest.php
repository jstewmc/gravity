<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Service;

use Jstewmc\Gravity\Deprecation\Data\Resolved;
use Jstewmc\Gravity\Id\Data\Service as Id;
use PHPUnit\Framework\Error\Deprecated;
use PHPUnit\Framework\TestCase;

/**
 * Based on phpunit.xml settings, PHPUnit will convert E_USER_DEPRECATED errors
 * to PHPUnit\Framework\Error\Deprecated exceptions.
 *
 * @see    https://stackoverflow.com/a/1227686  jason's answer to "Test the
 *  return value of a method that triggers an error with PHPUnit" on
 *  StackOverflow (accessed 12/3/17)
 */
class WarnTest extends TestCase
{
    public function testInvokeTriggersErrorIfReplacementDoesNotExist(): void
    {
        $this->expectException(Deprecated::class);

        $deprecation = new Resolved($this->mockSource());

        (new Warn())($deprecation);

        return;
    }

    public function testInvokeTriggersErrorIfReplacementDoesExist(): void
    {
        $this->expectException(Deprecated::class);

        $deprecation = new Resolved($this->mockSource(), $this->mockReplacement());

        (new Warn())($deprecation);

        return;
    }

    private function mockSource($path = 'foo')
    {
        $source = $this->createMock(Id::class);
        $source->method('__toString')->willReturn($path);

        return $source;
    }

    private function mockReplacement($path = 'bar')
    {
        $replacement = $this->createMock(Id::class);
        $replacement->method('__toString')->willReturn($path);

        return $replacement;
    }
}
