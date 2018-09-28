<?php
/**
 * The file for the setting deprecation tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Data;

use Jstewmc\Gravity\Id\Data\Setting as Id;
use PHPUnit\Framework\TestCase;


/**
 * Tests for a setting deprecation
 *
 * @since  0.1.0
 */
class SettingTest extends TestCase
{
    public function testGetId(): void
    {
        $id = $this->createMock(Id::class);

        $deprecation = new Setting($id);

        $this->assertSame($id, $deprecation->getId());

        return;
    }

    public function testGetReplacement(): void
    {
        $id  = $this->createMock(Id::class);
        $replacement = $this->createMock(Id::class);

        $deprecation = new Setting($id, $replacement);

        $this->assertSame($replacement, $deprecation->getReplacement());

        return;
    }

    public function testHasReplacementReturnsFalseIfReplacementDoesNotExist(): void
    {
        $id  = $this->createMock(Id::class);

        $deprecation = new Setting($id);

        $this->assertFalse($deprecation->hasReplacement());

        return;
    }

    public function testHasReplacementReturnsTrueIfReplacementDoesExist(): void
    {
        $id  = $this->createMock(Id::class);
        $replacement = $this->createMock(Id::class);

        $deprecation = new Setting($id, $replacement);

        $this->assertTrue($deprecation->hasReplacement());

        return;
    }

    public function testSetReplacement(): void
    {
        $id  = $this->createMock(Id::class);
        $replacement = $this->createMock(Id::class);

        $deprecation = new Setting($id);

        $this->assertSame($deprecation, $deprecation->setReplacement($replacement));

        return;
    }
}
