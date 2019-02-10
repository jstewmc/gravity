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
 *
 * @group  example
 */
class Test extends TestCase
{
    public function testAliasing(): void
    {
        require($this->getPathname('aliasing.php'));

        $this->expectOutputString('');

        return;
    }

    public function testBasic(): void
    {
        require($this->getPathname('basic.php'));

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


    /* !Private methods */

    /**
     * Returns the example scripts pathname
     *
     * @param   string  $filename  the script's pathname
     * @return  string
     * @since   0.1.0
     */
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
