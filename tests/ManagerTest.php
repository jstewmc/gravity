<?php
/**
 * The file for the manager tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity;

use PHPUnit\Framework\TestCase;
use StdClass;

/**
 * Tests for the manager
 *
 * Hmm, none of the manager's services are injected, so we have no control
 * over them. We can't mock or stub them. I guess we have to test the manager's
 * literal reurn values?
 *
 * @since  0.1.0
 */
class ManagerTest extends TestCase
{
    public function testAlias(): void
    {
        $g = new Manager();

        $this->assertSame($g, $g->alias('foo.baz.baz', 'foo.bar.qux'));

        return;
    }

    public function testDeprecate(): void
    {
        $g = new Manager();

        $this->assertSame($g, $g->deprecate('foo.baz.baz'));

        return;
    }

    public function testDestroy(): void
    {
        $this->assertNull((new Manager())->destroy());

        return;
    }

    public function testGet(): void
    {
        $identifier = 'foo.bar.baz';
        $value      = 1;

        $g = new Manager();

        $g->set($identifier, $value);

        $this->assertEquals($value, $g->get($identifier));

        return;
    }

    public function testHasReturnsFalseIfSettingDoesNotExist(): void
    {
        $g = new Manager();

        $this->assertFalse($g->has('foo.baz.baz'));

        return;
    }

    public function testHasReturnsFalseIfServiceDoesNotExist(): void
    {
        $g = new Manager();

        $this->assertFalse($g->has('foo\bar\baz'));

        return;
    }

    public function testHasReturnsTrueIfSettingDoesExist(): void
    {
        $g = new Manager();

        $g->set('foo.bar.baz', 1);

        $this->assertTrue($g->has('foo.bar.baz'));

        return;
    }

    public function testHasReturnsTrueIfServiceDoesExist(): void
    {
        $g = new Manager();

        $g->set('foo\bar\baz', function () { return new StdClass(); });

        $this->assertTrue($g->has('foo\bar\baz'));

        return;
    }

    public function testSetReturnsSelfIfSetting(): void
    {
        $g = new Manager();

        $this->assertSame($g, $g->set('foo.baz.baz', 1));

        return;
    }

    public function testSetReturnsSelfIfService(): void
    {
        $g = new Manager();

        $this->assertSame($g, $g->set('foo\bar\baz', new StdClass()));

        return;
    }
}
