<?php
/**
 * The file for service alias tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Alias\Data;

use Jstewmc\Gravity\Id\Data\Service as Id;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the service alias
 *
 * @since  0.1.0
 */
class ServiceTest extends TestCase
{
    public function testGetSource(): void
    {
        $source      = $this->createMock(Id::class);
        $destination = $this->createMock(Id::class);

        $alias = new Service($source, $destination);

        $this->assertSame($source, $alias->getSource());

        return;
    }

    public function testGetDestination(): void
    {
        $source      = $this->createMock(Id::class);
        $destination = $this->createMock(Id::class);

        $alias = new Service($source, $destination);

        $this->assertSame($destination, $alias->getDestination());

        return;
    }
}
