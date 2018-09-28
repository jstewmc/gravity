<?php
/**
 * The file for setting alias tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Alias\Data;

use Jstewmc\Gravity\Id\Data\Setting as Id;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the setting alias
 *
 * @since  0.1.0
 */
class SettingTest extends TestCase
{
    public function testGetSource(): void
    {
        $source      = $this->createMock(Id::class);
        $destination = $this->createMock(Id::class);

        $alias = new Setting($source, $destination);

        $this->assertSame($source, $alias->getSource());

        return;
    }

    public function testGetDestination(): void
    {
        $source      = $this->createMock(Id::class);
        $destination = $this->createMock(Id::class);

        $alias = new Setting($source, $destination);

        $this->assertSame($destination, $alias->getDestination());

        return;
    }
}
