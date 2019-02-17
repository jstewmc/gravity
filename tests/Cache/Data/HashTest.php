<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Cache\Data;

use Jstewmc\Gravity\Cache\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Hmm, these are tough to do without creating dependencies between the set(),
 * get(), and has() methods. But, if we don't, we're not really testing
 * behavior, just the static return types, which isn't helpful.
 *
 * @group cache
 */
class HashTest extends TestCase
{
    public function testClear(): void
    {
        $key   = 'foo';
        $cache = new Hash();

        $cache->set($key, 1);

        $this->assertTrue($cache->has($key));

        $cache->clear();

        $this->assertFalse($cache->has($key));
    }

    public function testDelete(): void
    {
        $key   = 'foo';
        $cache = new Hash();

        $cache->set($key, 1);

        $this->assertTrue($cache->has($key));

        $cache->delete($key);

        $this->assertFalse($cache->has($key));
    }

    public function testDeleteThrowsExceptionIfInputTypeNotValid(): void
    {
        $cache = new Hash();

        $this->expectException(InvalidArgumentException::class);

        $cache->delete(['foo']);
    }

    public function testDeleteThrowsExceptionIfObjectDoesNotImplementToString(): void
    {
        $cache   = new Hash();
        $service = $this->getAnonymousClass();

        $this->expectException(InvalidArgumentException::class);

        $cache->delete($service);
    }

    public function testDeleteMultiple(): void
    {
        $key   = 'foo';
        $keys  = [$key];
        $cache = new Hash();

        $cache->set($key, 1);

        $this->assertTrue($cache->has($key));

        $cache->deleteMultiple($keys);

        $this->assertFalse($cache->has($key));
    }

    public function testDeleteMultipleThrowsExceptionIfInputTypeInvalid(): void
    {
        $cache = new Hash();

        $this->expectException(InvalidArgumentException::class);

        $cache->deleteMultiple('foo');
    }

    public function testGet(): void
    {
        $key   = 'foo';
        $value = 1;
        $cache = new Hash();

        $cache->set($key, $value);

        $this->assertEquals($value, $cache->get($key));
    }

    public function testGetReturnsDefaultIfValueDoesNotExist(): void
    {
        $expected = ['foo'];
        $actual   = (new Hash())->get('foo', $expected);

        $this->assertSame($expected, $actual);
    }

    public function testGetThrowsExceptionIfInputTypeNotValid(): void
    {
        $cache = new Hash();

        $this->expectException(InvalidArgumentException::class);

        $cache->get(['foo']);
    }

    public function testGetThrowsExceptionIfObjectDoesNotImplementToString(): void
    {
        $cache   = new Hash();
        $service = $this->getAnonymousClass();

        $this->expectException(InvalidArgumentException::class);

        $cache->get($service);
    }

    public function testGetMultiple(): void
    {
        $key   = 'foo';
        $keys  = [$key];
        $value = 1;
        $cache = new Hash();

        $cache->set($key, $value);

        $this->assertContains($value, $cache->getMultiple($keys));
    }

    public function testGetMultipleThrowsExceptionIfInvalidType(): void
    {
        $cache = new Hash();

        $this->expectException(InvalidArgumentException::class);

        $cache->getMultiple('foo');
    }

    public function testGetMultipleReturnsDefaultIfNoneFound(): void
    {
        $key     = 'foo';
        $keys    = [$key];
        $cache   = new Hash();
        $default = ['bar'];

        $this->assertSame($default, $cache->getMultiple($keys, $default));
    }

    public function testHas(): void
    {
        $cache = new Hash();

        $cache->set('foo', 1);

        $this->assertTrue($cache->has('foo'));
    }

    public function testHasReturnsFalseIfKeyDoesNotExist(): void
    {
        $this->assertFalse((new Hash())->has('foo'));
    }

    public function testHasThrowsExceptionIfInputTypeNotValid(): void
    {
        $cache = new Hash();

        $this->expectException(InvalidArgumentException::class);

        $cache->has(['foo']);
    }

    public function testHasThrowsExceptionIfObjectDoesNotImplementToString(): void
    {
        $cache   = new Hash();
        $service = $this->getAnonymousClass();

        $this->expectException(InvalidArgumentException::class);

        $cache->has($service);
    }

    public function testSet(): void
    {
        $cache = new Hash();

        $cache->set('foo', true);

        $this->assertTrue($cache->has('foo'));
    }

    public function testSetThrowsExceptionIfInputTypeNotValid(): void
    {
        $cache = new Hash();

        $this->expectException(InvalidArgumentException::class);

        $cache->set(['foo'], 'foo');
    }

    public function testSetThrowsExceptionIfObjectDoesNotImplementToString(): void
    {
        $cache   = new Hash();
        $service = $this->getAnonymousClass();

        $this->expectException(InvalidArgumentException::class);

        $cache->set($service, 'foo');
    }

    public function testSetMultiple(): void
    {
        $cache = new Hash();

        $cache->setMultiple(['foo' => true]);

        $this->assertTrue($cache->has('foo'));
    }

    public function testSetMultipleThrowsExceptionIfInputTypeNotValid(): void
    {
        $cache = new Hash();

        $this->expectException(InvalidArgumentException::class);

        $cache->setMultiple('foo');
    }

    private function getAnonymousClass()
    {
        return new class {

        };
    }
}
