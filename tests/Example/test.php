<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Example;

use PHPUnit\Framework\Error\Deprecated;
use PHPUnit\Framework\TestCase;

/**
 * An empty output string is considered a success, because the examples include
 * assert() statements.
 */
class Test extends TestCase
{
    public function testAliasing(): void
    {
        require($this->getPathname('aliasing.php'));

        $this->expectOutputString('');

        return;
    }

    public function testFirst(): void
    {
        require($this->getPathname('first.php'));

        $this->expectOutputString('');

        return;
    }

    // set the warn-deprecation tests for an explanation of the exception
    public function testDeprecating(): void
    {
        $this->expectException(Deprecated::class);

        require($this->getPathname('deprecating.php'));

        return;
    }

    public function testGetting(): void
    {
        require($this->getPathname('getting.php'));

        $this->expectOutputString('');

        return;
    }

    public function testSetting(): void
    {
        require($this->getPathname('setting.php'));

        $this->expectOutputString('');

        return;
    }

    private function getPathname(string $filename): string
    {
        return realpath(
            implode(DIRECTORY_SEPARATOR, [
                dirname(__FILE__, 3),
                'examples',
                $filename
            ])
        );
    }
}
