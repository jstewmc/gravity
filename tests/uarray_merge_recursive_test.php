<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */
namespace Jstewmc\Gravity;

use PHPUnit\Framework\TestCase;

class uarray_merge_recursive_test extends TestCase
{
    // test that PHP's function behaves as we expect
    public function testArrayMergeRecursive(): void
    {
        $a = ['foo' => 'bar'];
        $b = ['foo' => 'baz'];

        $expected = ['foo' => ['bar', 'baz']];
        $actual   = array_merge_recursive($a, $b);

        $this->assertEquals($expected, $actual);
    }

    public function testIfArraysAreEmpty(): void
    {
        $this->assertEquals([], uarray_merge_recursive([], []));
    }

    public function testIfArraysAreOneDimensional(): void
    {
        $a = ['foo' => 'bar'];
        $b = ['foo' => 'baz'];

        $expected = ['foo' => 'baz'];
        $actual   = uarray_merge_recursive($a, $b);

        $this->assertEquals($expected, $actual);
    }

    public function testIfArraysAreManyDimensional(): void
    {
        $a = ['foo' => ['bar' => ['baz' => 'qux']]];
        $b = ['foo' => ['bar' => ['baz' => 'quux']]];

        $expected = ['foo' => ['bar' => ['baz' => 'quux']]];
        $actual   = uarray_merge_recursive($a, $b);

        $this->assertEquals($expected, $actual);
    }

    public function testIfArraysAreMixedDimensions(): void
    {
        $a = ['foo' => 0, 'bar' => 1, 'baz' => 2];
        $b = ['foo' => ['bar' => ['baz' => 'qux']]];

        $expected = ['foo' => ['bar' => ['baz' => 'qux']], 'bar' => 1, 'baz' => 2];
        $actual   = uarray_merge_recursive($a, $b);

        $this->assertEquals($expected, $actual);
    }

    public function testIfArraysAreZeroIndexed(): void
    {
        $a = ['foo' => ['bar', 'baz']];
        $b = ['foo' => ['qux']];

        $expected = ['foo' => ['bar', 'baz', 'qux']];
        $actual   = uarray_merge_recursive($a, $b);

        $this->assertEquals($expected, $actual);
    }
}
