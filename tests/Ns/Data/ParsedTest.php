<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Ns\Data;

use Jstewmc\Gravity\Import\Data as Import;
use Jstewmc\Gravity\Import\Exception\NotFound;
use Jstewmc\Gravity\Path\Data\Path;
use PHPUnit\Framework\TestCase;

/**
 * @group  namespace
 */
class ParsedTest extends TestCase
{
    public function testGetImportThrowsExceptionIfDoesNotExist(): void
    {
        $this->expectException(NotFound::class);

        (new Parsed())->getImport('foo');

        return;
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
