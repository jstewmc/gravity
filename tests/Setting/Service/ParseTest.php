<?php
/**
 * The file for the parse-setting service tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Setting\Service;

use Jstewmc\Gravity\Setting\Data\Setting;
use Jstewmc\Gravity\Id\Data\Setting as Id;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the parse-setting service
 *
 * @since  0.1.0
 */
class ParseTest extends TestCase
{
    public function testInvokeReturnsSettingIfValueIsScalar(): void
    {
        $value = 1;

        $id = $this->createMock(Id::class);
        $id->method('getSegments')->willReturn(['foo', 'bar', 'baz']);

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
        $actual = (new Parse())($id, $value);

        $this->assertEquals($expected, $actual);

        return;
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
        $id->method('getSegments')->willReturn(['foo', 'bar', 'baz']);

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
        $actual = (new Parse())($id, $value);

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeReturnsSettingIfValueIsMixedCase(): void
    {
        // make sure the keys are downcased but values are preserved
        $value = ['QUX' => 'QUUX'];

        $id = $this->createMock(Id::class);
        $id->method('getSegments')->willReturn(['foo', 'bar', 'baz']);

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
        $actual = (new Parse())($id, $value);

        $this->assertEquals($expected, $actual);

        return;
    }
}
