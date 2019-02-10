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

class OpenedTest extends TestCase
{
    public function testAddAlias(): void
    {
        $script = new Opened();

        $alias = $this->createMock(Alias::class);

        $this->assertSame($script, $script->addAlias($alias));
    }

    public function testAddDefinition(): void
    {
        $script = new Opened();

        $definition = $this->createMock(Definition::class);

        $this->assertSame($script, $script->addDefinition($definition));
    }

    public function testAddDeprecation(): void
    {
        $script = new Opened();

        $deprecation = $this->createMock(Deprecation::class);

        $this->assertSame($script, $script->addDeprecation($deprecation));
    }

    public function testGetAliases(): void
    {
        $this->assertEquals([], (new Opened())->getAliases());
    }

    public function testGetDefinitions(): void
    {
        $this->assertEquals([], (new Opened())->getDefinitions());
    }

    public function testGetDeprecations(): void
    {
        $this->assertEquals([], (new Opened())->getDeprecations());
    }

    public function testSetAliases(): void
    {
        $script = new Opened();

        $this->assertSame($script, $script->setAliases([]));
    }

    public function testSetDefinitions(): void
    {
        $script = new Opened();

        $this->assertSame($script, $script->setDefinitions([]));
    }

    public function testSetDeprecations(): void
    {
        $script = new Opened();

        $this->assertSame($script, $script->setDeprecations([]));
    }
}
