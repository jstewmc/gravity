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

    public function testSet(): void
    {
        $g = new Manager();

        $this->assertSame($g, $g->set('foo.baz.baz', 1));

        return;
    }
}
