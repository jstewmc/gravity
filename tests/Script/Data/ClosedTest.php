<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Script\Data;

use PHPUnit\Framework\TestCase;

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

    public function testGetRequirements(): void
    {
        $this->assertEquals([], (new Closed())->getRequirements());
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

    public function testSetRequirements(): void
    {
        $script = new Closed();

        $this->assertSame($script, $script->setRequirements([]));
    }
}
