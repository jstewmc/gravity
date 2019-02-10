<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Script\Data;

use PHPUnit\Framework\TestCase;

/**
 * @group  script
 */
class InterpretedTest extends TestCase
{
    public function testGetAliases(): void
    {
        $this->assertEquals([], (new Interpreted())->getAliases());
    }

    public function testGetDefinitions(): void
    {
        $this->assertEquals([], (new Interpreted())->getDefinitions());
    }

    public function testGetDeprecations(): void
    {
        $this->assertEquals([], (new Interpreted())->getDeprecations());
    }

    public function testGetServices(): void
    {
        $this->assertEquals([], (new Interpreted())->getServices());
    }

    public function testGetSettings(): void
    {
        $this->assertEquals([], (new Interpreted())->getSettings());
    }

    public function testSetAliases(): void
    {
        $script = new Interpreted();

        $this->assertSame($script, $script->setAliases([]));
    }

    public function testSetDefinitions(): void
    {
        $script = new Interpreted();

        $this->assertSame($script, $script->setDefinitions([]));
    }

    public function testSetDeprecations(): void
    {
        $script = new Interpreted();

        $this->assertSame($script, $script->setDeprecations([]));
    }

    public function testSetServices(): void
    {
        $script = new Interpreted();

        $this->assertSame($script, $script->setServices([]));
    }

    public function testSetSettings(): void
    {
        $script = new Interpreted();

        $this->assertSame($script, $script->setSettings([]));
    }
}
