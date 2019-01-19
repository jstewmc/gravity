<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Setting\Service;

use Jstewmc\Gravity\Definition\Data\Resolved as Definition;
use Jstewmc\Gravity\Id\Data\Setting as Id;
use Jstewmc\Gravity\Path\Data\Setting as Path;
use Jstewmc\Gravity\Setting\Data\Setting;
use PHPUnit\Framework\TestCase;

/**
 * @group  setting
 */
class InterpretTest extends TestCase
{
    public function testInvokeReturnsSettingIfValueIsScalar(): void
    {
        $value = 1;

        $id = $this->createMock(Id::class);

        $definition = $this->createMock(Definition::class);
        $definition->method('getSegments')->willReturn(['foo', 'bar', 'baz']);
        $definition->method('getValue')->willReturn($value);
        $definition->method('getKey')->willReturn($id);

        $expected = new Setting(
            $id,
            [
                'foo' => [
                    'bar' => [
                        'baz' => $value
                    ],
                ],
            ]
        );
        $actual = (new Interpret())($definition);

        $this->assertEquals($expected, $actual);
    }

    public function testInvokeReturnsSettingIfValueIsArray(): void
    {
        $value = [
            'qux' => [
                'quux' => 1
            ],
            'corge' => [
                'grault' => 2
            ]
        ];

        $id = $this->createMock(Id::class);

        $definition = $this->createMock(Definition::class);
        $definition->method('getSegments')->willReturn(['foo', 'bar', 'baz']);
        $definition->method('getValue')->willReturn($value);
        $definition->method('getKey')->willReturn($id);

        $expected = new Setting(
            $id,
            [
                'foo' => [
                    'bar' => [
                        'baz' => $value
                    ],
                ],
            ]
        );
        $actual = (new Interpret())($definition);

        $this->assertEquals($expected, $actual);
    }

    public function testInvokeReturnsSettingIfValueIsMixedCase(): void
    {
        $value = ['QUX' => 'QUUX'];

        $id = $this->createMock(Id::class);

        $definition = $this->createMock(Definition::class);
        $definition->method('getSegments')->willReturn(['foo', 'bar', 'baz']);
        $definition->method('getValue')->willReturn($value);
        $definition->method('getKey')->willReturn($id);

        $expected = new Setting(
            $id,
            [
                'foo' => [
                    'bar' => [
                        'baz' => [
                            'qux' => 'QUUX'
                        ]
                    ],
                ],
            ]
        );
        $actual = (new Interpret())($definition);

        $this->assertEquals($expected, $actual);
    }
}
