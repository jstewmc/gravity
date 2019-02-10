<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Import\Data;

use Jstewmc\Gravity\Path\Data\Path;
use PHPUnit\Framework\TestCase;

class ParsedTest extends TestCase
{
    public function testGetName(): void
    {
        $path = $this->createMock(Path::class);

        $import = new Parsed($path, 'foo');

        $this->assertEquals('foo', $import->getName());

        return;
    }

    public function testGetPath(): void
    {
        $path = $this->createMock(Path::class);

        $import = new Parsed($path, 'foo');

        $this->assertSame($path, $import->getPath());

        return;
    }
}
