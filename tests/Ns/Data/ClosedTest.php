<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Ns\Data;

use PHPUnit\Framework\TestCase;

class ClosedTest extends TestCase
{
    public function testGetImports(): void
    {
        $this->assertEmpty((new Closed())->getImports());

        return;
    }

    public function testGetName(): void
    {
        $this->assertNull((new Closed())->getName());

        return;
    }

    public function testHasImports(): void
    {
        $this->assertFalse((new Closed())->hasImports());

        return;
    }

    public function testHasName(): void
    {
        $this->assertFalse((new Closed())->hasName());

        return;
    }

    public function testIsEmpty(): void
    {
        $this->assertTrue((new Closed())->isEmpty());

        return;
    }

    public function testSetName(): void
    {
        $namespace = new Closed();

        $this->assertSame($namespace, $namespace->setName('foo'));

        return;
    }

    public function testSetImports(): void
    {
        $namespace = new Closed();

        $this->assertSame($namespace, $namespace->setImports([]));

        return;
    }
}
