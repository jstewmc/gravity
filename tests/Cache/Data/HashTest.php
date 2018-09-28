<?php
/**
 * The file for a hash-based cache
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Cache\Data;

use Jstewmc\Gravity\Cache\Exception\NotFound;
use Jstewmc\Gravity\Id\Data\Id;
use PHPUnit\Framework\TestCase;

/**
 * Tests for a hash-based cache
 *
 * @since  0.1.0
 * @group  todo
 */
class HashTest extends TestCase
{
    /* get, has, remove, reset, and set */

    public function testGet_throwsException_ifValueDoesNotExist(): void
    {
        $this->expectException(NotFound::class);

        (new Hash())->get($this->createMock(Id::class));

        return;
    }

    /*
    public function testGet_returnsValue_ifValueDoesExist(): void
    {

    }

    public function testHas_returnsFalse_ifValueDoesNotExist(): void
    {

    }

    public function testHas_returnsTrue_ifValueDoesExist(): void
    {

    }

    public function testRemove(): void
    {

    }

    public function testReset(): void
    {

    }
    */

    public function testSet(): void
    {
        $cache = new Hash();

        $id = $this->createMock(Id::class);

        $this->assertSame($cache, $cache->set($id, true));

        return;
    }
}
