<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Path\Service;

use Jstewmc\Gravity\Path\Data\{Service, Setting};
use Jstewmc\Gravity\Path\Exception\TypeMismatch;
use PHPUnit\Framework\TestCase;

/**
 * @group  path
 */
class MergeTest extends TestCase
{
    public function testInvokeThrowsExceptionIfTypeMismatch(): void
    {
        $this->expectException(TypeMismatch::class);

        // use concrete classes because PHPUnit mocks are same class
        $a = new Setting(['foo', 'bar']);
        $b = new Service(['baz', 'qux']);

        (new Merge())($a, $b);

        return;
    }

    public function testInvokeReturnsPathIfTypeService(): void
    {
        $a = $this->createMock(Service::class);
        $a->method('getSegments')->willReturn(['foo', 'bar']);

        $b = $this->createMock(Service::class);
        $b->method('getSegments')->willReturn(['baz', 'qux']);

        $expected = new Service(['foo', 'bar', 'baz', 'qux']);
        $actual   = (new Merge())($a, $b);

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeReturnsPathIfTypeSetting(): void
    {
        $a = $this->createMock(Setting::class);
        $a->method('getSegments')->willReturn(['foo', 'bar']);

        $b = $this->createMock(Setting::class);
        $b->method('getSegments')->willReturn(['baz', 'qux']);

        $expected = new Setting(['foo', 'bar', 'baz', 'qux']);
        $actual   = (new Merge())($a, $b);

        $this->assertEquals($expected, $actual);

        return;
    }
}
