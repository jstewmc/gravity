<?php
/**
 * The file for setting tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Setting\Data;

use Jstewmc\Gravity\Id\Data\Setting as Id;
use PHPUnit\Framework\TestCase;

/**
 * Tests for a setting
 *
 * @since  0.1.0
 */
class SettingTest extends TestCase
{
    public function testGetId(): void
    {
        $id = $this->createMock(Id::class);

        $setting = new Setting($id, []);

        $this->assertSame($id, $setting->getId());

        return;
    }

    public function testGetArray(): void
    {
        $id = $this->createMock(Id::class);
        $array      = ['foo' => 'bar'];

        $setting = new Setting($id, $array);

        $this->assertEquals($array, $setting->getArray());

        return;
    }
}
