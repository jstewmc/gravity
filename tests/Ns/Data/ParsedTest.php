<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Ns\Data;

use Jstewmc\Gravity\Import\Data\Parsed as Import;
use Jstewmc\Gravity\Import\Exception\NotFound;
use PHPUnit\Framework\TestCase;

class ParsedTest extends TestCase
{
    public function testGetImportThrowsExceptionIfDoesNotExist(): void
    {
        $this->expectException(NotFound::class);

        (new Parsed())->getImport('foo');

        return;
    }

    public function testGetImport(): void
    {
        $name = 'foo';

        $import = $this->createMock(Import::class);
        $import->method('getName')->willReturn($name);

        $namespace = (new Parsed())->setImports([$import]);

        $this->assertSame($import, $namespace->getImport($name));
    }

    public function testGetImports(): void
    {
        $this->assertEmpty((new Parsed())->getImports());

        return;
    }

    public function testGetName(): void
    {
        $this->assertNull((new Parsed())->getName());

        return;
    }

    public function testHasImport(): void
    {
        $this->assertFalse((new Parsed())->hasImport('foo'));

        return;
    }

    public function testHasImports(): void
    {
        $this->assertFalse((new Parsed())->hasImports());

        return;
    }

    public function testHasName(): void
    {
        $this->assertFalse((new Parsed())->hasName());

        return;
    }

    public function testIsEmpty(): void
    {
        $this->assertTrue((new Parsed())->isEmpty());

        return;
    }
}
