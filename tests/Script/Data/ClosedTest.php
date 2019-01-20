<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Script\Data;

use Jstewmc\Gravity\Alias\Data\Read as Alias;
use Jstewmc\Gravity\Definition\Data\Read as Definition;
use Jstewmc\Gravity\Deprecation\Data\Read as Deprecation;
use PHPUnit\Framework\TestCase;

/**
 * @group  script
 */
class ClosedTest extends TestCase
{
    public function testGetAliases(): void
    {
        $this->assertEquals([], (new Closed())->getAliases());
    }

    public function testGetDefinitions(): void
    {
        $this->assertEquals([], (new Closed())->getDefinitions());
    }

    public function testGetDeprecations(): void
    {
        $this->assertEquals([], (new Closed())->getDeprecations());
    }

    public function testSetAliases(): void
    {
        $script = new Closed();

        $this->assertSame($script, $script->setAliases([]));
    }

    public function testSetDefinitions(): void
    {
        $script = new Closed();

        $this->assertSame($script, $script->setDefinitions([]));
    }

    public function testSetDeprecations(): void
    {
        $script = new Closed();

        $this->assertSame($script, $script->setDeprecations([]));
    }
}
