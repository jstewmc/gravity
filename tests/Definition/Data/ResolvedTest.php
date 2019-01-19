<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Definition\Data;

use Jstewmc\Gravity\Id\Data\Id;
use PHPUnit\Framework\TestCase;

/**
 * @group  definition
 */
class ResolvedTest extends TestCase
{
    public function testGetKey(): void
    {
        $id = $this->createMock(Id::class);

        $this->assertSame($id, (new Resolved($id))->getKey());

        return;
    }

    public function testGetValue(): void
    {
        $id = $this->createMock(Id::class);

        $this->assertNull((new Resolved($id))->getValue());

        return;
    }

    public function testSetValue(): void
    {
        $id = $this->createMock(Id::class);

        $definition = new Resolved($id);

        $this->assertSame($definition, $definition->setValue('bar'));

        return;
    }
}
