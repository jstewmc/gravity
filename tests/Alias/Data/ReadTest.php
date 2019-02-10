<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Alias\Data;

use Jstewmc\Gravity\Alias\Exception\Circular;
use PHPUnit\Framework\TestCase;

class ReadTest extends TestCase
{
    public function testConstructThrowsExceptionIfCircular(): void
    {
        $this->expectException(Circular::class);

        new Read('foo', 'foo');

        return;
    }

    public function testGetSource(): void
    {
        $source = 'foo';

        $alias = new Read($source, 'bar');

        $this->assertEquals($source, $alias->getSource());

        return;
    }

    public function testGetDestination(): void
    {
        $destination = 'bar';

        $alias = new Read('foo', $destination);

        $this->assertEquals($destination, $alias->getDestination());

        return;
    }
}
