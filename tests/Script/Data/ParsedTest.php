<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Script\Data;

use PHPUnit\Framework\TestCase;

class ParsedTest extends TestCase
{
    public function testGetAliases(): void
    {
        $this->assertEquals([], (new Parsed())->getAliases());
    }

    public function testGetDefinitions(): void
    {
        $this->assertEquals([], (new Parsed())->getDefinitions());
    }

    public function testGetDeprecations(): void
    {
        $this->assertEquals([], (new Parsed())->getDeprecations());
    }

    public function testSetAliases(): void
    {
        $script = new Parsed();

        $this->assertSame($script, $script->setAliases([]));
    }

    public function testSetDefinitions(): void
    {
        $script = new Parsed();

        $this->assertSame($script, $script->setDefinitions([]));
    }

    public function testSetDeprecations(): void
    {
        $script = new Parsed();

        $this->assertSame($script, $script->setDeprecations([]));
    }
}
