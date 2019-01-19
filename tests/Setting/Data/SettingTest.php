<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Setting\Data;

use Jstewmc\Gravity\Id\Data\Setting as Id;
use PHPUnit\Framework\TestCase;

/**
 * @group  setting
 */
class SettingTest extends TestCase
{
    public function testGetId(): void
    {
        $id = $this->createMock(Id::class);

        $setting = new Setting($id, []);

        $this->assertSame($id, $setting->getId());
    }

    public function testGetArray(): void
    {
        $id    = $this->createMock(Id::class);
        $array = ['foo' => 'bar'];

        $setting = new Setting($id, $array);

        $this->assertEquals($array, $setting->getArray());
    }
}
