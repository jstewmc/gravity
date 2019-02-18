<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Requirement\Data;

use Jstewmc\Gravity\Id\Data\{
    Id,
    Service as ServiceId,
    Setting as SettingId
};
use PHPUnit\Framework\TestCase;

class ResolvedTest extends TestCase
{
    private $key;

    public function setUp(): void
    {
        $this->key = $this->createMock(Id::class);
    }

    public function testGetDescription(): void
    {
        $description = 'bar';

        $requirement = new Resolved($this->key, $description, function ($value) {
            return true;
        });

        $this->assertEquals($description, $requirement->getDescription());
    }

    public function testGetKey(): void
    {
        $requirement = new Resolved($this->key, 'bar', function ($value) {
            return true;
        });

        $this->assertSame($this->key, $requirement->getKey());
    }

    public function testGetValidator(): void
    {
        $validator = function ($value) {
            return true;
        };

        $requirement = new Resolved($this->key, 'bar', $validator);

        $this->assertEquals($validator, $requirement->getValidator());
    }

    public function testIsService(): void
    {
        $key = $this->createMock(ServiceId::class);

        $requirement = new Resolved($key, 'bar', function () {
            return true;
        });

        $this->assertTrue($requirement->isService());
    }

    public function testIsSetting(): void
    {
        $key = $this->createMock(SettingId::class);

        $requirement = new Resolved($key, 'bar', function () {
            return true;
        });

        $this->assertTrue($requirement->isSetting());
    }
}
