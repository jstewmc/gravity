<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Ns\Data;

use Jstewmc\Gravity\Import\Data\Read as Import;
use PHPUnit\Framework\TestCase;

/**
 * @group  namespace
 */
class OpenedTest extends TestCase
{
    public function testAddImport(): void
    {
        $import = $this->createMock(Import::class);

        $namespace = new Opened();

        $this->assertSame($namespace, $namespace->addImport($import));

        return;
    }

    public function testGetImports(): void
    {
        $namespace = new Opened();

        $this->assertEquals([], $namespace->getImports());

        return;
    }

    public function testGetName(): void
    {
        $namespace = new Opened();

        $this->assertNull($namespace->getName());

        return;
    }

    public function testHasImports(): void
    {
        $this->assertFalse((new Opened())->hasImports());

        return;
    }

    public function testHasName(): void
    {
        $this->assertFalse((new Opened())->hasName());

        return;
    }

    public function testIsEmpty(): void
    {
        $this->assertTrue((new Opened())->isEmpty());

        return;
    }

    public function testSetName(): void
    {
        $namespace = new Opened();

        $this->assertSame($namespace, $namespace->setName('foo'));

        return;
    }
}
