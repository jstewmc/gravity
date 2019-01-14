<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Import\Data;

use PHPUnit\Framework\TestCase;

/**
 * @group  import
 */
class ReadTest extends TestCase
{
    public function testGetNameIfNameDoesExist(): void
    {
        $import = new Read('foo.bar.baz', 'qux');

        $this->assertEquals('qux', $import->getName());

        return;
    }

    public function testGetNameIfNameDoesNotExist(): void
    {
        $this->assertNull((new Read('foo.bar.baz'))->getName());

        return;
    }

    public function testGetPath(): void
    {
        $import = new Read('foo.bar.baz');

        $this->assertEquals('foo.bar.baz', $import->getPath());

        return;
    }
}
